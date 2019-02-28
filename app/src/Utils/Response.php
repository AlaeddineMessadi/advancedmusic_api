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
        return new JsonResponse(
            [
                'code' => $httpCode,
                'message' => $payload
            ],
            $httpCode);
    }
}