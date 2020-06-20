<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * The "AbstractApiErrorRequest" class
 */
abstract class AbstractApiErrorRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $response = response()->json(compact('errors'), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        throw new HttpResponseException($response);
    }
}
