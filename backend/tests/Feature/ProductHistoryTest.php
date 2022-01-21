<?php

namespace Tests\Feature;

use App\Models\ProductHistory;
use App\Models\Products;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    /** @test */
    public function history_json_format()
    {
        $product = Products::factory()
            ->has(ProductHistory::factory()->count(2), 'history')
            ->create(['quantity' => 40]);

        $response = $this->getJson("api/products/$product->sku/history");

        $history = $product->history->map(fn ($item) => $item->only(['quantity_change', 'created_at']));
        $response->assertStatus(200)
            ->assertExactJson($history->toArray());
    }

    /** @test */
    public function create_history_on_increase()
    {
        $product = Products::factory()->create(['quantity' => 40]);

        $this->patchJson("api/products/$product->sku/increase", [ 'value' => 5 ]);

        $history = $product->history->get(0);

        $this->assertEquals($history->quantity_change, 5);
    }

    /** @test */
    public function create_history_on_decrease()
    {
        $product = Products::factory()->create(['quantity' => 40]);

        $this->patchJson("api/products/$product->sku/decrease", [ 'value' => 5 ]);

        $history = $product->history->get(0);

        $this->assertEquals($history->quantity_change, -5);
    }

    /** @test */
    public function create_history_on_quantity_set()
    {
        $product = Products::factory()->create(['quantity' => 40]);

        $this->patchJson("api/products/$product->sku", [ 'quantity' => 30 ]);

        $history = $product->history->get(0);

        $this->assertEquals($history->quantity_change, -10);
    }
}
