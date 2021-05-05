<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\Response\RestApiResponse;

abstract class BaseController extends Controller
{
    protected const CREATED = 'created';

    protected function success(
        $data,
        int $statusCode = JsonResponse::HTTP_OK
    ): RestApiResponse {
        return new RestApiResponse(true, $data, $statusCode);
    }
}
