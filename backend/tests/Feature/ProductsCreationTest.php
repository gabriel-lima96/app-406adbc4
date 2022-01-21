<?php

namespace Tests\Feature;

use App\Models\Products;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsCreationTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function response_must_be_successful(): void
    {
        $product = Products::factory()->make()->toArray();

        $response = $this->postJson('api/products', $product);

        $url = $this->prepareUrlForRequest('api/products');
        $response->assertStatus(201)
            ->assertJsonFragment($product)
            ->assertHeader('Location', "$url/${product['sku']}");
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

    /** @test */
    public function product_will_be_created(): void
    {
        $product = Products::factory()->make();

        $this->postJson('api/products', $product->toArray());
        $fetchedProduct = Products::where('sku', $product->sku)->first();

        $this->assertTrue($fetchedProduct->exists);
    }
}
