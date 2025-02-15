<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Product;

class ProductVariantController extends Controller
{
    use AuthorizesRequests;

    //  Lấy danh sách biến thể của sản phẩm
    public function index($product_id)
    {
        $product = Product::findOrFail($product_id);
        $variants = ProductVariant::with(['size', 'color'])
            ->where('product_id', $product_id)
            ->get();

        return response()->json([
            'product' => $product->name,
            'variants' => $variants
        ]);
    }

    //  Thêm biến thể mới (Chỉ Admin)
    public function store(Request $request, $product_id)
    {
        $this->authorize('admin'); // Chỉ admin mới có quyền

        $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'stock' => 'required|integer|min:0',
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product_id,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'stock' => $request->stock
        ]);

        return response()->json(['message' => 'Biến thể đã được thêm!', 'variant' => $variant], 201);
    }

    //  Cập nhật số lượng tồn kho của biến thể (Chỉ Admin)
    public function update(Request $request, $id)
    {
        $this->authorize('admin'); // Chỉ admin mới có quyền

        $variant = ProductVariant::findOrFail($id);

        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $variant->update(['stock' => $request->stock]);

        return response()->json(['message' => 'Biến thể đã được cập nhật!', 'variant' => $variant]);
    }

    //  Xóa biến thể (Chỉ Admin)
    public function destroy($id)
    {
        $this->authorize('admin'); // Chỉ admin mới có quyền

        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response()->json(['message' => 'Biến thể đã bị xóa!']);
    }
}