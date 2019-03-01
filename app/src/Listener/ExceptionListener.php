<?php

namespace App\Listener;

use App\Utils\HttpCode;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class ExceptionListener
 * @package App\Exception
 */
class ExceptionListener
{
    protected $kernel;

    /**
     * ExceptionListener constructor.
     * @param $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = new Response();
        $statusCode = HttpCode::INTERNAL_SERVER_ERROR;
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $response->headers->replace($exception->getHeaders());
        }

        $content = [
            'code' => $statusCode,
            'message' => $exception->getMessage()
        ];

        if ('dev' == $this->kernel->getEnvironment()) {
            $trace = $exception->getTrace();
            if (!json_encode($trace)){
                $content['trace'] = $exception->getTraceAsString();
            } else {
                $content['trace'] = $trace;
            }
            $content['line'] = $exception->getLine();
        }

        $response->setContent(json_encode($content));
        $response->setStatusCode($statusCode);

        $event->setResponse($response);
    }
}