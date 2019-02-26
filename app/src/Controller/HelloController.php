<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloController extends FOSRestController
{
	/**
	 * @Route("/", name="hello")
     */
    public function indexAction(): Response
    {
        return new JsonResponse([
            'API' => 'Advanced Music API',
            'version' => 'v1'
        ]);
    }
}
