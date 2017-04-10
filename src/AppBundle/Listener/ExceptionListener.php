<?php

namespace AppBundle\Listener;

use AppBundle\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof InvalidFormException) {
            return;
        }

        $responseData = $exception->getForm();

        $event->setResponse(new JsonResponse($responseData, 400));
    }
}