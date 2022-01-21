<?php

namespace Tests\Feature;

use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsQueryTest extends TestCase
{
    /** @test */
    public function list_products(): void
    {
        $product = Products::factory()->create();

        $response = $this->getJson('api/products');

        $response->assertStatus(200)
            ->assertJsonFragment([ $product->toArray() ]);
    }

    /** @test */
    public function find_product(): void
    {
        $product = Products::factory()->create();

        $response = $this->getJson('api/products/' . $product->sku);

        $response->assertStatus(200)
            ->assertJson($product->toArray());
    }
}
