<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductVariantController;


//  Đăng ký & Đăng nhập 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//  Nhóm API sử dụng `apiResource()` (CRUD)
Route::apiResource('/cart-items', CartItemController::class);
Route::apiResource('/orders', OrderController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/brands', BrandController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('product-variants', ProductVariantController::class);

Route::apiResource('/reviews', ReviewController::class);

//  Giảm giá
Route::post('/discounts/apply', [DiscountController::class, 'applyDiscount']);

//  Thanh toán
Route::post('/payments', [PaymentController::class, 'store']);

//  Quản lý Admin 
Route::get('/admin/users', [AdminController::class, 'index']);
Route::get('/admin/statistics', [AdminController::class, 'statistics']);
Route::get('/admin/reviews', [AdminController::class, 'reviews']);
Route::delete('/admin/reviews/{id}', [AdminController::class, 'deleteReview']);
