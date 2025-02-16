<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        return response()->json(Discount::all());
    }

    public function store(Request $request)
    {
        $discount = Discount::create($request->all());
        return response()->json($discount, 201);
    }

    public function show($id)
    {
        return response()->json(Discount::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->all());
        return response()->json($discount);
    }

    public function destroy($id)
    {
        Discount::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function applyDiscount(Request $request)
    {
        // Xử lý logic áp dụng mã giảm giá (ví dụ: kiểm tra mã hợp lệ)
        return response()->json(['message' => 'Discount applied successfully']);
    }
}
