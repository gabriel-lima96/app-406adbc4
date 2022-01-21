<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsDecreaseRequest extends ProductsIncreaseRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['value'][] = function (string $attribute, int $value, $fail) {
            if ($this->product->quantity - $value < 0) {
                $fail('Subtraction value must less than ' . $this->product->quantity . ' otherwise stock will be negative.');
            }
        };
        return $rules;
    }
}
