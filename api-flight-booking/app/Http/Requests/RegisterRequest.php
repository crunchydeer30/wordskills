<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if (isset($this->phone)) {
            $this->merge([
                'phone' => Helpers::formatPhoneNumber($this->phone),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:12', 'max:12', 'unique:users,phone', 'regex:/^\+7\d{10}$/'],
            'document_number' => ['required', 'string', 'min:10', 'max:10', 'unique:users,document_number', 'regex:/[0-9]{10}/'],
            'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]+$/']
        ];
    }
}
