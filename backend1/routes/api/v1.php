<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ProductVariantController;
use Illuminate\Support\Facades\Route;

// Resource routes
Route::apiResource('brands', BrandController::class);
Route::apiResource('cart-items', CartItemController::class)->middleware('auth:api');
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('variants', ProductVariantController::class);
Route::apiResource('colors', ColorController::class);
Route::apiResource('discounts', DiscountController::class);
Route::apiResource('images', ImageController::class);
Route::apiResource('orders', OrderController::class)->middleware('auth:api');
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('payments', PaymentController::class)->middleware('auth:api');
Route::apiResource('reviews', ReviewController::class);
Route::apiResource('sizes', SizeController::class);
Route::apiResource('users', UsersController::class);
