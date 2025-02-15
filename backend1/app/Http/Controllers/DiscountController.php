<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Discount;
use Carbon\Carbon;

class DiscountController extends Controller
{
    //  Lấy danh sách mã giảm giá (chỉ admin)
    public function index()
    {
        $discounts = Discount::orderBy('created_at', 'desc')->get();
        return response()->json(['discounts' => $discounts]);
    }

    //  Xem chi tiết mã giảm giá
    public function show($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Mã giảm giá không tồn tại!'], 404);
        }
        return response()->json(['discount' => $discount]);
    }

    //  Admin tạo mã giảm giá mới
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:discounts,code|max:50',
            'discount_type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $discount = Discount::create($request->all());

        return response()->json([
            'message' => 'Mã giảm giá đã được tạo!',
            'discount' => $discount
        ], 201);
    }

    //  Admin cập nhật mã giảm giá
    public function update(Request $request, $id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Mã giảm giá không tồn tại!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'string|unique:discounts,code,' . $id . '|max:50',
            'discount_type' => 'in:fixed,percentage',
            'value' => 'numeric|min:0',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $discount->update($request->all());

        return response()->json([
            'message' => 'Mã giảm giá đã được cập nhật!',
            'discount' => $discount
        ]);
    }

    //  Admin xóa mã giảm giá
    public function destroy($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Mã giảm giá không tồn tại!'], 404);
        }

        $discount->delete();
        return response()->json(['message' => 'Mã giảm giá đã được xóa thành công!']);
    }

    //  Áp dụng mã giảm giá khi thanh toán
    public function applyDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|exists:discounts,code',
            'total_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $discount = Discount::where('code', $request->code)->first();

        // Kiểm tra mã giảm giá còn hiệu lực
        $now = Carbon::now();
        if ($now < $discount->start_date || $now > $discount->end_date) {
            return response()->json(['message' => 'Mã giảm giá đã hết hạn!'], 400);
        }

        // Tính toán giá trị giảm
        $discountAmount = ($discount->discount_type == 'percentage')
            ? ($request->total_price * $discount->value / 100)
            : $discount->value;

        $finalPrice = max(0, $request->total_price - $discountAmount);

        return response()->json([
            'message' => 'Mã giảm giá hợp lệ!',
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice
        ]);
    }
}
