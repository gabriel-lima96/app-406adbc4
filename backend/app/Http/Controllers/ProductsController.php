<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsIncreaseRequest;
use App\Http\Requests\ProductsDecreaseRequest;
use App\Http\Requests\ProductsPatchRequest;
use App\Http\Requests\ProductsPostRequest;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
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
        $data = $request->validated();

        $product->quantity = $data['quantity'];

        if (! $product->save())
            return response(status: 500);

        return response(status: 204);
    }

    public function increase(ProductsIncreaseRequest $request, Products $product): Response
    {
        $data = $request->validated();

        $product->quantity += $data['value'];

        if (! $product->save())
            return response(status: 500);

        return response(status: 204);
    }

    public function decrease(ProductsDecreaseRequest $request, Products $product): Response
    {
        $data = $request->validated();

        $product->quantity -= $data['value'];

        if (! $product->save())
            return response(status: 500);

        return response(status: 204);
    }

//    public function destroy(Products $products): JsonResponse
//    {
//        //
//    }
}
