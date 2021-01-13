<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Trait for standard responses
 */
trait ApiResponser
{
    /**
     * Success response in json
     *
     * @param array $data
     * @param integer $code
     * @return JsonResponse
     */   
    public function successResponse(array $response, int $code = 200) : JsonResponse
    {
        return new JsonResponse($response, $code);
    }

    public function errorResponse(string $message, int $code) : JsonResponse
    {
        $error = [
            'error' => [
                'message' => $message
            ] 
        ];

        return new JsonResponse($error, $code);
    }
}