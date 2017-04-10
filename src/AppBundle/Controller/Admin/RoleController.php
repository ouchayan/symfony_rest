<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Role;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use AppBundle\Form\RoleType;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends FOSRestController {

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get Role by Id",
     *  section="Role",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="the id of the role"
     *      }
     *  },
     * )
     * @View()
     * @return array
     */
    public function getRoleAction($id) {
        return $this->getOr404($id);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get All Roles",
     *  section="Role",
     * )
     * @View()
     * @return array
     */
    public function getRolesAction() {
        return $this->getHandler()->all();
    }
    
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new Feature",
     *  input = "AppBundle\Form\FeatureType",
     *  output = "AppBundle\Entity\Feature",
     *  section="Role",
     *  statusCodes={
     *         201="Returned when a new Feature has been successfully created",
     *         400="Returned when the posted data is invalid"
     *     }
     * )
     *
     * @View()
     *
     * @param Request $request
     * @return array|\FOS\RestBundle\View\View|null
     */
    public function postRoleCreateAction(Request $request) {
        try {
            $role = $this->getHandler()->post(
                    $request->request->all()
            );
            $routeOptions = array(
                'id' => $role->getId(),
                '_format' => $request->get('_format'),
            );
            return $this->routeRedirectView(
                            'get_role', $routeOptions, Response::HTTP_CREATED
            );
        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update an existing Role",
     *  section="Role",
     *  statusCodes={
     *         201="Returned when a new Feature has been successfully created",
     *         204="Returned when an existing Feature has been successfully updated",
     *         400="Returned when the posted data is invalid"
     *     }
     * )
     *
     * @param Request $request
     * @param         $id
     * @return array|\FOS\RestBundle\View\View|null
     */
    public function putRoleAction(Request $request, $id) {
        $role = $this->getHandler()->get($id);
        try {
            if ($role === null) {
                $statusCode = Response::HTTP_CREATED;
                $role = $this->getHandler()->post(
                        $request->request->all()
                );
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $role = $this->getHandler()->put(
                        $role, $request->request->all()
                );
            }
            $routeOptions = array(
                'id' => $role->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('get_role', $routeOptions, $statusCode);
        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Delete an existing Role",
     *  section="Role",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="the id of the Role to delete"
     *      }
     *  },
     *  statusCodes={
     *         204="Returned when an existing Role has been successfully deleted",
     *         404="Returned when trying to delete a non existent Role"
     *     }
     * )
     *
     * @param Request $request
     * @param         $id
     */
    public function deleteRoleAction(Request $request, $id) {
        $role = $this->getOr404($id);
        $this->getHandler()->delete($role);
    }

    /**
     * Returns a record by id, or throws a 404 error
     *
     * @param $id
     * @return mixed
     */
    protected function getOr404($id) {
        $handler = $this->getHandler();
        $data = $handler->get($id);
        if (null === $data) {
            throw new NotFoundHttpException();
        }
        return $data;
    }

    /**
     * Returns the required handler for this controller
     *
     * @return \AppBundle\Handler\RoleHandler
     */
    private function getHandler() {
        return $this->get('role_handler');
    }

}
