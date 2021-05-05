<?php

namespace App\Http\Requests;

use App\Exceptions\Validation\ValidationRequestException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class AbstractRequest extends FormRequest
{
    /**
     * @throws ValidationRequestException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
        throw new ValidationRequestException($errors);
    }

    protected function getDefaultRules(): array
    {
        return [
            // On future
        ];
    }
}
