<?php
namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Lấy danh sách sản phẩm (Public API)
    public function index()
    {
        $products = Product::with(['category', 'brand', 'images', 'variants'])
                           ->paginate(10);  // Ensure relationships are loaded
        return ProductResource::collection($products);
    }

    // Tạo mới sản phẩm (Admin API)
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json([
            'message' => 'Sản phẩm đã được tạo!',
            'product' => new ProductResource($product)
        ], 201);
    }

    // Xem chi tiết sản phẩm (Public API)
    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'images', 'variants'])
                          ->findOrFail($id);  // Ensure relationships are loaded
        return new ProductResource($product);
    }

    // Cập nhật sản phẩm (Admin API)
    public function update(StoreProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return response()->json([
            'message' => 'Sản phẩm đã được cập nhật!',
            'product' => new ProductResource($product)
        ]);
    }

    // Xóa sản phẩm (Admin API)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();  // Soft delete by default, or use `destroy()` for hard delete
        return response()->json(['message' => 'Sản phẩm đã được xóa thành công!']);
    }
}
