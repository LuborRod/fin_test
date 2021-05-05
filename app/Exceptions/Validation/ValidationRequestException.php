<?php

namespace App\Exceptions\Validation;

use Illuminate\Http\JsonResponse;

class ValidationRequestException extends \Exception
{
    private array $errors;

    public function __construct(array $errors = [])
    {
        parent::__construct('', JsonResponse::HTTP_BAD_REQUEST);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
