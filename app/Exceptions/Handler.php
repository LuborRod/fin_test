<?php

namespace App\Exceptions;

use App\Exceptions\Validation\ValidationRequestException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    private const ROUTE_NOT_FOUND = 'Route not found';
    private const SERVER_ERROR = 'Ooops, something went wrong';

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return $this->renderException(['error' => $e->getMessage()], JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        });
        $this->renderable(function (ValidationRequestException $e) {
            return $this->renderException($e->getErrors(), $e->getCode());
        });
        $this->renderable(function (NotFoundHttpException $e) {
            return $this->renderException(['not_found' => [self::ROUTE_NOT_FOUND]], JsonResponse::HTTP_NOT_FOUND);
        });
        $this->renderable(function (BadRequestHttpException $e) {
            return $this->renderException(['bad_request' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        });
        $this->renderable(function (\Exception $e) {
            return $this->renderException(['error' => self::SERVER_ERROR], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        });
    }


    /**
     * @param array $errors
     * @param int $code
     * @return JsonResponse
     */
    private function renderException(array $errors, int $code): JsonResponse
    {
        $response = [
            'success' => false,
            'errors' => $errors,
        ];

        return new JsonResponse($response, $code);
    }
}
