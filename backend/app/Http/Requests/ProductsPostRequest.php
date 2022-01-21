<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:products',
            'sku' => 'required|max:255|unique:products',
            'quantity' => 'required|min:0|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'A product :attribute is required',
            'max:255' => 'A product :attribute max length is 255',
            'unique:products' => 'A product with this :attribute already exists',
            'integer' => 'The :attribute must be an integer',
            'min:0' => 'The :attribute must be greater than zero',
        ];
    }
}
