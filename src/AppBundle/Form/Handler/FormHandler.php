<?php

namespace AppBundle\Form\Handler;

use AppBundle\Exception\InvalidFormException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormError;

class FormHandler {

    private $em;
    private $formFactory;
    private $formType;

    public function __construct(ObjectManager $objectManager, FormFactoryInterface $formFactory, FormTypeInterface $formType) {
        $this->em = $objectManager;
        $this->formFactory = $formFactory;
        $this->formType = $formType;
    }

    public function processForm($object, array $parameters, $method) {
        $form = $this->formFactory->create($this->formType, $object, array(
            'method' => $method,
            'csrf_protection' => false,
        ));
        $form->submit($parameters, 'PATCH' !== $method);
        if (!$form->isValid()) {
            throw new InvalidFormException($this->getFormErrors($form));
        }
        $data = $form->getData();
        $this->em->persist($data);
        $this->em->flush();
        return $data;
    }

    public function delete($object) {
        $this->em->remove($object);
        $this->em->flush();
        return true;
    }

    public function importData($object, array $parameters, $method) {
        $form = $this->formFactory->create($this->formType, $object, array(
            'method' => $method,
            'csrf_protection' => false,
        ));
        $form->submit($parameters, 'PATCH' !== $method);
        if (!$form->isValid()) {
            return $this->getFormErrors($form);
        }
        $data = $form->getData();
        $this->em->persist($data);
        $this->em->flush();
        return $data;
    }

    protected function getFormErrors($form) {
        $result = [];
        $errors = $form->getErrors();
        if (count($errors)) {
            $result['errors'] = [];
            foreach ($errors as $error) {
                $result['errors'][] = $error->getMessage();
            }
        }

        if ($form->count()) {
            $childErrors = [];
            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    $childErrors[$child->getName()] = $this->getFormErrors($child);
                }
            }
            if (count($childErrors)) {
                $result = $childErrors;
            }
        }

        return $result;
    }

}
