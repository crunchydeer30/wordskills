<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'document_number' => ['required', 'string', 'min:10', 'max:10'],
            'password' => ['required', 'string'],
        ];
    }
}
