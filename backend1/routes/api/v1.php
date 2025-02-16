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
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ImageController;


// 🔹 Đăng ký & Đăng nhập
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔹 Nhóm API sử dụng `apiResource()` (CRUD)
Route::apiResource('/cart-items', CartItemController::class);
Route::apiResource('/orders', OrderController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/brands', BrandController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/reviews', ReviewController::class);
Route::apiResource('colors', ColorController::class);
Route::apiResource('sizes', SizeController::class);
Route::apiResource('images', ImageController::class);
Route::post('images/upload', [ImageController::class, 'upload']);


// 🔹 Quản lý biến thể sản phẩm
Route::apiResource('/products/{product}/variants', ProductVariantController::class)
    ->except(['show']); // Giới hạn các phương thức không cần thiết

// 🔹 Giảm giá
Route::prefix('discounts')->group(function () {
    Route::post('/apply', [DiscountController::class, 'applyDiscount']); // Áp dụng mã giảm giá
    Route::get('/', [DiscountController::class, 'index']); // Lấy danh sách mã giảm giá (nếu cần)
});

// 🔹 Thanh toán
Route::post('/payments', [PaymentController::class, 'store']);

// 🔹 Quản lý Admin
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/statistics', [AdminController::class, 'statistics']);
    Route::get('/reviews', [AdminController::class, 'reviews']);
    Route::delete('/reviews/{id}', [AdminController::class, 'deleteReview']);
});
