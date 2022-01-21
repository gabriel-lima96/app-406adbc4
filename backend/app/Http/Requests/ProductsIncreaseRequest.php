<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsIncreaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'min:0',
                'integer'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'A :attribute is required',
            'integer' => 'The :attribute must be an integer',
            'min:0' => 'The :attribute must be greater than zero',
        ];
    }
}
