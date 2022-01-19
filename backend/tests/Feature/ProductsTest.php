<?php

namespace Tests\Feature;

use App\Models\Products;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function list_all_products(): void
    {
        $product = Products::factory()->create();

        $response = $this->getJson('api/products');

        $response->assertStatus(200)
            ->assertJson([ $product->toArray() ]);
    }

    /** @test */
    public function create_a_product(): void
    {
        $product = Products::factory()->make()->toArray();

        $response = $this->postJson('api/products', $product);

        $response->assertStatus(201)
            ->assertJsonFragment($product);
    }

    /** @test */
    public function quantity_must_be_positive(): void
    {
        $product = Products::factory()->make()->toArray();

        $product['quantity'] = -1;

        $response = $this->postJson('api/products', $product);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('quantity');
    }

    /** @test */
    public function sku_must_be_unique(): void
    {
        $product = Products::factory()->make()->toArray();

        $this->postJson('api/products', $product);
        $response = $this->postJson('api/products', $product);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'sku']);
    }

    /** @test */
    public function validate_required_fields(): void
    {
        $response = $this->postJson('api/products', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'sku', 'quantity']);
    }
}
