<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Response
 * @package App\Utils
 */
class Response
{
    /**
     * @param int $httpCode
     * @param string $payload
     * @return JsonResponse
     */
    public static function toJson(int $httpCode, $payload = 'success'): JsonResponse
    {
        $response = ['code' => $httpCode];
        if (is_array($payload)) {
            $response = array_merge($response, $payload);
        } else {
            $response = array_merge($response, ['message' => $payload]);
        }

        return new JsonResponse($response, $httpCode);
    }
}