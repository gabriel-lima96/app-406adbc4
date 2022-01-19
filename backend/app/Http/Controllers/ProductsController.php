<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Products;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{

    public function index(): JsonResponse
    {
        $products = Products::all();

        return response()->json($products, 200);
    }

    public function store(ProductsRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = Products::create($data);

        return response()->json($product, 201);
    }

//    public function show(Products $products): JsonResponse
//    {
//        //
//    }

//    public function update(ProductsRequest $request, Products $products): JsonResponse
//    {
//        //
//    }

//    public function destroy(Products $products): JsonResponse
//    {
//        //
//    }
}
