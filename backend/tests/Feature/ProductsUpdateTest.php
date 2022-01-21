<?php

namespace Tests\Feature;

use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsUpdateTest extends TestCase
{
    /** @test */
    public function quantity_will_change(): void
    {
        $product = Products::factory()->create(['quantity' => 1]);
        $data = [
            'quantity' => 2
        ];

        $response = $this->patchJson('api/products/' . $product->sku, $data);
        $product->refresh();

        $response->assertStatus(204);
        $this->assertEquals($data['quantity'], $product->quantity);
    }

    /** @test */
    public function quantity_cant_be_negative(): void
    {
        $product = Products::factory()->create();

        $data = [
            'quantity' => -1
        ];

        $response = $this->patchJson('api/products/' . $product->sku, $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('quantity');
    }

    /** @test */
    public function quantity_must_be_required(): void
    {
        $product = Products::factory()->create();

        $response = $this->patchJson('api/products/' . $product->sku, []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantity']);
    }

    /** @test */
    public function other_fields_must_be_prohibited(): void
    {
        $product = Products::factory()->create();

        $response = $this->patchJson('api/products/' . $product->sku, [
            'name' => $product->name,
            'sku' => $product->sku
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'sku']);
    }

    /** @test */
    public function able_to_increase(): void
    {
        $product = Products::factory()->create(['quantity' => 10]);
        $data = [
            'value' => 2
        ];

        $response = $this->patchJson('api/products/' . $product->sku . '/increase', $data);
        $product->refresh();

        $response->assertStatus(204);
        $this->assertEquals(12, $product->quantity);
    }

    /** @test */
    public function able_to_decrease(): void
    {
        $product = Products::factory()->create(['quantity' => 10]);
        $data = [
            'value' => 2
        ];

        $response = $this->patchJson('api/products/' . $product->sku . '/decrease', $data);
        $product->refresh();

        $response->assertStatus(204);
        $this->assertEquals(8, $product->quantity);
    }

    /** @test */
    public function cannot_decrease_if_quantity_is_less_than_decrease_value(): void
    {
        $product = Products::factory()->create(['quantity' => 1]);
        $data = [
            'value' => 2
        ];

        $response = $this->patchJson('api/products/' . $product->sku . '/decrease', $data);
        $product->refresh();

        $response->assertStatus(422)
            ->assertJsonValidationErrors('value');
    }
}
