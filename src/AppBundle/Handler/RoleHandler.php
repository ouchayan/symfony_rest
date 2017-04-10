<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Role;
use AppBundle\Repository\RoleRepository;
use AppBundle\Form\Handler\FormHandler;

/**
 * RoleHandler service Class
 *
 * @category Class
 * @package  Handler
 * @author   Ouchayan Hamid <ouchayan.h@gmail.com>
 */

class RoleHandler implements HandlerInterface
{

    private $repository;
    private $formHander;

    /**
     * Constructor function
     *
     * @param RoleRepository $roleRepository
     * @param FormHandler $formHandler
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepository, FormHandler $formHandler)
    {
        $this->repository = $roleRepository;
        $this->formHander = $formHandler;
    }

    /**
     * get role by id
     *
     * @param int $id role id
     *
     * @return Object
     *
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all the roles
     *
     * @return array
     *
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * Create new role
     *
     * @param array $parameters role data
     *
     * @return Object
     *
     */
    public function post(array $parameters)
    {
        return $this->formHander->processForm(
            new Role(),
            $parameters,
            "POST"
        );
    }

    /**
     * Update role
     *
     * @param Role  $role
     * @param array $parameters role data
     *
     * @return object
     */
    public function put(Role $role, array $parameters)
    {
        return $this->formHander->processForm(
            $role,
            $parameters,
            "PUT"
        );
    }

    /**
     * delete role
     *
     * @param Role $role
     *
     * @return boolean
     */
    public function delete(Role $role)
    {
        return $this->formHander->delete($role);
    }
}
