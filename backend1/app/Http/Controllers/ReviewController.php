<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    //  Lấy danh sách đánh giá của một sản phẩm
    public function index(Request $request)
    {
        $product_id = $request->query('product_id');
        if (!$product_id) {
            return response()->json(['message' => 'Vui lòng cung cấp product_id'], 400);
        }

        $reviews = Review::where('product_id', $product_id)
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['reviews' => $reviews]);
    }

    //  Người dùng gửi đánh giá sản phẩm
    public function store(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:100000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm!'], 404);
        }

        // Kiểm tra nếu người dùng đã đánh giá trước đó
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return response()->json(['message' => 'Bạn đã đánh giá sản phẩm này!'], 400);
        }

        // Tạo đánh giá mới
        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Đánh giá của bạn đã được gửi!',
            'review' => $review
        ], 201);
    }

    //  Admin xóa đánh giá
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Không tìm thấy đánh giá!'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Đánh giá đã được xóa thành công!']);
    }
}
