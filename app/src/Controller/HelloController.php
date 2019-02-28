<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends BaseController
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
