<?php

namespace AppBundle\Handler;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Form\Handler\FormHandler;

/**
 * UserHandler service Class
 *
 * @category Class
 * @package  Handler
 * @author   Ouchayan Hamid <ouchayan.h@gmail.com>
 */

class UserHandler implements HandlerInterface
{

    private $repository;
    private $formHander;
    private $container;

    /**
     * Constructor function
     *
     * @param UserRepository     $userRepository
     * @param FormHandler     $formHandler
     * @param ContainerInterface $container
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, FormHandler $formHandler, ContainerInterface $container)
    {
        $this->repository = $userRepository;
        $this->formHander = $formHandler;
        $this->container = $container;
    }

    /**
     * Create new user
     *
     * @param array $parameters user data
     *
     * @return Object
     *
     */
    public function post(array $parameters)
    {
        return $this->formHander->processForm(
            new User(),
            $parameters,
            "POST"
        );
    }

    /**
     * get user by id
     *
     * @param int $id user id
     *
     * @return Object
     *
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all the users
     *
     * @return array
     *
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * Update user
     *
     * @param User  $user
     * @param array $parameters user data
     *
     * @return object
     */
    public function put(User $user, array $parameters)
    {
        return $this->formHander->processForm(
            $user,
            $parameters,
            "PUT"
        );
    }

    /**
     * get user by feature code in order to check if the user has the permission to access to specific feature
     *
     * @param User   $user
     * @param string $code feature code
     *
     * @return array
     */
    public function getUsersByFeatureCode($user, $code)
    {
        return $this->repository->getUsersByFeatureCode($user, $code);
    }

    /**
     * get user by criteria
     *
     * @param array $criteria
     *
     * @return array
     */
    public function getUserByCriteria($criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * get user by email
     *
     * @param email $email
     *
     * @return object
     */
    public function getUserOneByEmail($email)
    {
        return $this->repository->findOneByEmail($email);
    }
}
