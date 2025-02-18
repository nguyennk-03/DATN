<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    // Lấy tất cả các mã giảm giá
    public function index()
    {
        $discounts = Discount::all();
        return response()->json($discounts);
    }

    // Áp dụng mã giảm giá
    public function applyDiscount(Request $request)
    {
        // Xác thực mã giảm giá
        $validated = $request->validate([
            'code' => 'required|string|exists:discounts,code',
            'total_price' => 'required|numeric|min:0',
        ]);

        $discount = Discount::where('code', $validated['code'])->first();

        // Kiểm tra điều kiện mã giảm giá
        $currentDate = now();

        if ($currentDate < $discount->start_date || $currentDate > $discount->end_date) {
            return response()->json(['error' => 'Mã giảm giá không còn hiệu lực'], 400);
        }

        // Áp dụng giảm giá vào tổng giá trị
        $discountAmount = 0;
        if ($discount->discount_type == 'fixed') {
            $discountAmount = $discount->value;
        } else if ($discount->discount_type == 'percentage') {
            $discountAmount = ($discount->value / 100) * $validated['total_price'];
        }

        $newTotalPrice = $validated['total_price'] - $discountAmount;
        return response()->json([
            'discount_amount' => $discountAmount,
            'new_total_price' => $newTotalPrice,
            'discount_code' => $discount->code,
        ]);
    }

    // Tạo mới một mã giảm giá
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code',
            'discount_type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_uses' => 'nullable|integer|min:1',
        ]);

        $discount = Discount::create($validated);
        return response()->json($discount, 201);
    }

    // Cập nhật một mã giảm giá
    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code,' . $id,
            'discount_type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_uses' => 'nullable|integer|min:1',
        ]);

        $discount->update($validated);
        return response()->json($discount);
    }

    // Xóa một mã giảm giá
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return response()->json(null, 204);
    }
}
