<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsIncreaseRequest;
use App\Http\Requests\ProductsDecreaseRequest;
use App\Http\Requests\ProductsPatchRequest;
use App\Http\Requests\ProductsPostRequest;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ProductsController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Products::all();

        return response()->json($products, 200);
    }

    public function store(ProductsPostRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = Products::create($data);
        $url = URL::current();

        return response()->json($product, 201)->header('Location', "$url/$product->sku");
    }

    public function show(Products $product): JsonResponse
    {
        return response()->json($product);
    }

    public function update(ProductsPatchRequest $request, Products $product): Response
    {
        return DB::transaction(function () use ($request, $product) {
            $data = $request->validated();

            $changed_quantity = $data['quantity'] - $product->quantity;
            $product->quantity = $data['quantity'];

            $product->save();
            $product->history()->create([
                'quantity_change' => $changed_quantity
            ]);

            return response(status: 204);
        });
    }

    public function increase(ProductsIncreaseRequest $request, Products $product): Response
    {
        return DB::transaction(function () use ($request, $product) {
            $data = $request->validated();

            $product->quantity += $data['value'];

            $product->save();
            $product->history()->create([
                'quantity_change' => $data['value']
            ]);

            return response(status: 204);
        });
    }

    public function decrease(ProductsDecreaseRequest $request, Products $product): Response
    {
        return DB::transaction(function () use ($request, $product) {
            $data = $request->validated();

            $product->quantity -= $data['value'];

            $product->save();
            $product->history()->create([
                'quantity_change' => - $data['value']
            ]);

            return response(status: 204);
        });
    }

//    public function destroy(Products $products): JsonResponse
//    {
//        //
//    }
}
