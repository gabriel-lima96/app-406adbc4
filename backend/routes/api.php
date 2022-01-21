<?php

use App\Http\Controllers\ProductHistoryController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{product:sku}', [ProductsController::class, 'show']);
Route::get('/products/{product:sku}/history', [ProductHistoryController::class, 'index']);
Route::post('/products', [ProductsController::class, 'store']);
Route::patch('/products/{product:sku}', [ProductsController::class, 'update']);
Route::patch('/products/{product:sku}/increase', [ProductsController::class, 'increase']);
Route::patch('/products/{product:sku}/decrease', [ProductsController::class, 'decrease']);
