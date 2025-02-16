<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductVariantResource;
use App\Models\ProductVariant;
use App\Http\Requests\StoreProductVariantRequest;

class ProductVariantController extends Controller
{
    // Lấy danh sách biến thể sản phẩm
    public function index()
    {
        $variants = ProductVariant::with(['product', 'size', 'color', 'images'])->paginate(10); 
        return ProductVariantResource::collection($variants);
    }

    // Tạo mới biến thể sản phẩm
    public function store(StoreProductVariantRequest $request)
    {
        $variant = ProductVariant::create($request->validated());
        return response()->json([
            'message' => 'Biến thể sản phẩm đã được tạo!',
            'variant' => new ProductVariantResource($variant)
        ], 201);
    }

    // Xem chi tiết biến thể sản phẩm
    public function show($id)
    {
        $variant = ProductVariant::with(['product', 'size', 'color', 'images'])->findOrFail($id);
        return new ProductVariantResource($variant);
    }

    // Cập nhật biến thể sản phẩm
    public function update(StoreProductVariantRequest $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->update($request->validated());
        return response()->json([
            'message' => 'Biến thể sản phẩm đã được cập nhật!',
            'variant' => new ProductVariantResource($variant)
        ]);
    }

    // Xóa biến thể sản phẩm
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();
        return response()->json(['message' => 'Biến thể sản phẩm đã được xóa thành công!']);
    }
}
