<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class ApiRequest extends FormRequest
{
  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'success' => false,
      'message' => $validator->errors()
    ], 422));
  }
}
