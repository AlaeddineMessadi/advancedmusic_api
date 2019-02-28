<?php

namespace App\Controller;


use App\Utils\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends FOSRestController
{
    protected function getDataFromRequest(Request $request)
    {
        $data = json_decode($request->getContent(), false);
        if ($data === null) {
            $res = (object)$request->query->all();
            return $res;
        }

        return $data;
    }

    /**
     * @param int $httpCode
     * @param mixed $payload
     * @return JsonResponse
     */
    protected function jsonResponse (int $httpCode, $payload = 'success') : JsonResponse {
        return Response::toJson($httpCode, $payload);
    }
}