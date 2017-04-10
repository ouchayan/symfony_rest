<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use AppBundle\Form\RoleType;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController {

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get User by Id",
     *  section="User",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="the id of the feature"
     *      }
     *  },
     * )
     * @View()
     * @return array
     */
    public function getUserAction($id) {
        return $this->getOr404($id);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get All Users",
     *  section="User",
     * )
     * @View()
     * @return array
     */
    public function getUsersAction() {
        return $this->getHandler()->all();
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new User",
     *  input = "AppBundle\Form\FeatureType",
     *  output = "AppBundle\Entity\Feature",
     *  section="User",
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
    public function postUserCreateAction(Request $request) {
        $params = $request->request->all();
        try {
            $offre = $this->getHandler()->post(
                    $params
            );
            $routeOptions = array(
                'id' => $offre->getId(),
                '_format' => $request->get('_format'),
            );
            return $this->routeRedirectView(
                            'get_offre', $routeOptions, Response::HTTP_CREATED
            );
        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update an existing User",
     *  section="User",
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
    public function putUserAction(Request $request, $id) {
        $params = $request->request->all();
        $params["enabled"] = $params["enabled"] == "true" ? true : false;
        $user = $this->getHandler()->get($id);
        try {
            if ($user === null) {
                $statusCode = Response::HTTP_CREATED;
                $user = $this->getHandler()->post(
                        $params
                );
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $user = $this->getHandler()->put(
                        $user, $params
                );
            }
            $routeOptions = array(
                'id' => $user->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('get_user', $routeOptions, $statusCode);
        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Delete an existing User",
     *  section="User",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="the id of the Role to delete"
     *      }
     *  },
     *  statusCodes={
     *         204="Returned when an existing User has been successfully deleted",
     *         404="Returned when trying to delete a non existent User"
     *     }
     * )
     *
     * @param Request $request
     * @param         $id
     */
    public function deleteUserAction(Request $request, $id) {
        $user = $this->getOr404($id);
        $this->getHandler()->delete($user);
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
     * @return \AppBundle\Handler\UserHandler
     */
    private function getHandler() {
        return $this->get('user_handler');
    }

}
