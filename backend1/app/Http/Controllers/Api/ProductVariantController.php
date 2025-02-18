<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    // Lấy tất cả các biến thể sản phẩm
    public function index()
    {
        $variants = ProductVariant::all();
        return response()->json($variants);
    }

    // Lấy chi tiết một biến thể sản phẩm
    public function show($id)
    {
        $variant = ProductVariant::with(['product', 'size', 'color'])->findOrFail($id);
        return response()->json($variant);
    }

    // Tạo mới một biến thể sản phẩm
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
        ]);

        $variant = ProductVariant::create($validated);
        return response()->json($variant, 201);
    }

    // Cập nhật một biến thể sản phẩm
    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
        ]);

        $variant->update($validated);
        return response()->json($variant);
    }

    // Xóa một biến thể sản phẩm
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();
        return response()->json(null, 204);
    }
}
