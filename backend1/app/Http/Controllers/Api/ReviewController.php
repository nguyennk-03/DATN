<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Lấy tất cả các đánh giá của một sản phẩm
    public function index($productId)
    {
        $product = Product::findOrFail($productId);

        // Lấy tất cả các đánh giá của sản phẩm
        $reviews = $product->reviews()->with('user')->get();

        return response()->json($reviews);
    }

    // Tạo mới một đánh giá cho sản phẩm
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Tạo mới một đánh giá
        $review = Review::create([
            'user_id' => Auth::id(), // Lấy id người dùng đã đăng nhập
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json($review, 201);
    }

    // Cập nhật đánh giá của người dùng
    public function update(Request $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Kiểm tra nếu người dùng là tác giả của đánh giá
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Bạn không có quyền sửa đánh giá này.'], 403);
        }

        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cập nhật đánh giá
        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json($review);
    }

    // Xóa đánh giá của người dùng
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Kiểm tra nếu người dùng là tác giả của đánh giá
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Bạn không có quyền xóa đánh giá này.'], 403);
        }

        // Xóa đánh giá
        $review->delete();

        return response()->json(['message' => 'Đánh giá đã được xóa.']);
    }
}