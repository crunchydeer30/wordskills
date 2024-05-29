<?php

namespace App\Http\Requests\Trips;

use Illuminate\Foundation\Http\FormRequest;

class GetManyRequest extends FormRequest
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
            'from' => 'required|string|exists:stations,code',
            'to' => 'required|string|exists:stations,code',
            'date1' => 'required|date|date_format:Y-m-d',
            'date2' => 'optional|date|date_format:Y-m-d',
            'passengers' => 'required|numeric|min:1|max:25',
        ];
    }
}
