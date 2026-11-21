<?php

use App\Http\Controllers\Api\CafeApiController;
use Illuminate\Support\Facades\Route;

// สินค้า
Route::get('/products', [CafeApiController::class, 'products']);
Route::get('/categories', [CafeApiController::class, 'categories']);

// ออเดอร์
Route::post('/orders', [CafeApiController::class, 'createOrder']);
Route::get('/orders/{id}', [CafeApiController::class, 'getOrder']);
Route::post('/orders/{id}/pay-later', [CafeApiController::class, 'payLater']);
Route::post('/orders/{id}/payment', [CafeApiController::class, 'uploadSlip']);

