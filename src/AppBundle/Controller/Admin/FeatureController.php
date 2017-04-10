<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Feature;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use AppBundle\Form\FeatureType;
use Symfony\Component\HttpFoundation\Response;

class FeatureController extends FOSRestController {

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get Feature by Id",
     *  section="Feature",
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
    public function getFeatureAction($id) {
        return $this->getOr404($id);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get All Features",
     *  section="Feature",
     * )
     * @View()
     * @return array
     */
    public function getFeaturesAction() {
        return $this->getHandler()->all();
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new Feature",
     *  input = "AppBundle\Form\FeatureType",
     *  output = "AppBundle\Entity\Feature",
     *  section="Feature",
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
    public function postFeatureCreateAction(Request $request) {
        try {
            $feature = $this->getHandler()->post(
                    $request->request->all()
            );
            return $feature;
            $routeOptions = array(
                'id' => $feature->getId(),
                '_format' => $request->get('_format'),
            );
            return $this->routeRedirectView(
                            'get_feature', $routeOptions, Response::HTTP_CREATED
            );
        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update an existing Feature",
     *  section="Feature",
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
    public function putFeatureAction(Request $request, $id) {
        $feature = $this->getHandler()->get($id);
        try {
            if ($feature === null) {
                $statusCode = Response::HTTP_CREATED;
                $feature = $this->getHandler()->post(
                        $request->request->all()
                );
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $feature = $this->getHandler()->put(
                        $feature, $request->request->all()
                );
            }
            $routeOptions = array(
                'id' => $feature->getId(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('get_feature', $routeOptions, $statusCode);
        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Delete an existing Feature",
     *  section="Feature",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+", "description"="the id of the Feature to delete"
     *      }
     *  },
     *  statusCodes={
     *         204="Returned when an existing Feature has been successfully deleted",
     *         404="Returned when trying to delete a non existent Feature"
     *     }
     * )
     *
     * @param Request $request
     * @param         $id
     */
    public function deleteFeatureAction(Request $request, $id) {
        $feature = $this->getOr404($id);
        $this->getHandler()->delete($feature);
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
     * @return \AppBundle\Handler\FeatureHandler
     */
    private function getHandler() {
        return $this->get('feature_handler');
    }

}
