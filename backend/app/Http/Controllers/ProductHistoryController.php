<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\JsonResponse;

class ProductHistoryController extends Controller
{
    public function index(Products $product): JsonResponse
    {
        $history = $product->history->map(fn ($item) => $item->only(['quantity_change', 'created_at']));

        return response()->json($history);
    }

//    public function store(Request $request): Response
//    {
//        //
//    }
//
//    public function show(ProductHistory $productHistory): Response
//    {
//        //
//    }
//
//    public function update(Request $request, ProductHistory $productHistory): Response
//    {
//        //
//    }
//
//    public function destroy(ProductHistory $productHistory): Response
//    {
//        //
//    }
}
