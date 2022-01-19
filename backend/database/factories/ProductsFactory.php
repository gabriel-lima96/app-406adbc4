<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'sku' => $this->faker->regexify('[A-Z]{0,5}[0-4]{3}-\w{0,7}'),
            'quantity' => $this->faker->numberBetween(0, 30)
        ];
    }
}
