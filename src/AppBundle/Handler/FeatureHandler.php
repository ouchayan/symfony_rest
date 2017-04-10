<?php
namespace AppBundle\Handler;

use AppBundle\Entity\Feature;
use AppBundle\Repository\FeatureRepository;
use AppBundle\Form\Handler\FormHandler;

/**
 * FeatureHandler service Class
 *
 * @category Class
 * @package  Handler
 * @author   Ouchayan Hamid <ouchayan.h@gmail.com>
 */

class FeatureHandler implements HandlerInterface
{

    private $repository;
    private $formHander;

    /**
     * Constructor function
     *
     * @param FeatureRepository $featureRepository
     * @param FormHandler       $formHandler
     *
     * @return void
     */
    public function __construct(FeatureRepository $featureRepository, FormHandler $formHandler)
    {
        $this->repository = $featureRepository;
        $this->formHander = $formHandler;
    }

    /**
     * get feature by id
     *
     * @param int $id feature id
     *
     * @return Object
     *
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all the features
     *
     * @return array
     *
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * Create new feature
     *
     * @param array $parameters feature data
     *
     * @return Object
     *
     */
    public function post(array $parameters)
    {
        return $this->formHander->processForm(
            new Feature(),
            $parameters,
            "POST"
        );
    }

    /**
     * Update feature
     *
     * @param Feature $feature
     * @param array   $parameters feature data
     *
     * @return object
     */
    public function put(Feature $feature, array $parameters)
    {
        return $this->formHander->processForm(
            $feature,
            $parameters,
            "PUT"
        );
    }

    /**
     * delete feature
     *
     * @param Feature $feature
     *
     * @return boolean
     */
    public function delete(Feature $feature)
    {
        return $this->formHander->delete($feature);
    }
}
