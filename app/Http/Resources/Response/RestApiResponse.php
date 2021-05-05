<?php

namespace App\Http\Resources\Response;

use Illuminate\Http\JsonResponse;

class RestApiResponse extends JsonResponse
{
    public function __construct(bool $success, $data, int $statusCode)
    {
        $response = [
            'success' => $success,
            'data' => $data,
        ];

        parent::__construct($response, $statusCode);
    }
}
