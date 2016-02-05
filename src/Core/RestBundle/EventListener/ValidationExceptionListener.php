<?php

namespace Core\RestBundle\EventListener;

use Core\RestBundle\Exception\ValidationException;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
class ValidationExceptionListener
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        if(!$exception instanceof ValidationException)
            return;

        // Customize your response object to display the exception details
        $response = new Response();

        $validationErrors = $exception->getErrorList();

        $errorArray = array();

        foreach($validationErrors as $error)
        {
            $errorArray[$error->getPropertyPath()] = $error->getMessage();
        }
        //TODO permettre de paramétrer le format de renvoi des erreurs
        $errorMessage = json_encode($errorArray);//$this->serializer->serialize($validationErrors, 'json');
        $response->setContent($errorMessage);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Send the modified response object to the event
        $event->setResponse($response);
    }
}