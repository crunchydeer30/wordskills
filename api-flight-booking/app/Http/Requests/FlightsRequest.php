<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightsRequest extends FormRequest
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
            'from' => ['required', 'string', 'exists:airports,iata'],
            'to' => ['required', 'string', 'exists:airports,iata'],
            'date1' => ['required', 'date', 'date_format:Y-m-d', 'after:today'],
            'date1' => ['date', 'date_format:Y-m-d', 'after:today'],
            'passengers' => ['required', 'numeric', 'min:1', 'max:8'],
        ];
    }
}
