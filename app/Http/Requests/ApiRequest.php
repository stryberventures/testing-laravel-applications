<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class ApiRequest extends FormRequest
{
    final public function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'errors' => $validator->errors()->toArray()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }

    abstract function rules(): array;
}
