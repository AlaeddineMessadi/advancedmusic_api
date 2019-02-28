<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloController extends AbstractFOSRestController
{
	/**
	 * @Rest\Route("/", name="hello")
     */
    public function indexAction(): Response
    {
        return new JsonResponse([
            'API' => 'Advanced Music API',
            'version' => 'v1'
        ]);
    }
}
