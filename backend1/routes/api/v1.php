<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PaymentController;

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

//Kiểm tra API hoạt động
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});

//Authentication (Không cần đăng nhập)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Route yêu cầu đăng nhập
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // API dành cho khách hàng
    Route::apiResource('/cart-items', CartItemController::class)->except(['update']);
    Route::apiResource('/orders', OrderController::class)->only(['store', 'index', 'show']);
    Route::apiResource('/payments', PaymentController::class)->only(['store']);
    Route::apiResource('/reviews', ReviewController::class)->only(['store']);
    Route::post('/discounts/apply', [DiscountController::class, 'applyDiscount']);
});

//API Public (Ai cũng có thể truy cập)
Route::apiResource('/categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('/brands', BrandController::class)->only(['index', 'show']);
Route::apiResource('/products', ProductController::class)->only(['index', 'show']);
Route::apiResource('/reviews', ReviewController::class)->only(['index', 'show']);
Route::apiResource('/discounts', DiscountController::class)->only(['index', 'show']);

// API tùy chỉnh cho Products
Route::get('/products/search', [ProductController::class, 'search']); // Tìm kiếm sản phẩm
Route::get('/products/filter', [ProductController::class, 'filter']); // Lọc theo danh mục/thương hiệu/giá
Route::get('/products/{slug}', [ProductController::class, 'showBySlug']); // Lấy sản phẩm theo slug

//API dành cho Admin (Cần quyền admin)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('/categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('/brands', BrandController::class)->except(['index', 'show']);
    Route::apiResource('/products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('/variants', ProductVariantController::class)->except(['show']);
    Route::get('/products/{product_id}/variants', [ProductVariantController::class, 'indexByProduct']);
    Route::apiResource('/orders', OrderController::class)->only(['update']);
    Route::apiResource('/payments', PaymentController::class)->only(['index', 'update']);
    Route::apiResource('/reviews', ReviewController::class)->only(['destroy']);
    Route::apiResource('/discounts', DiscountController::class)->except(['index', 'show']);
});
