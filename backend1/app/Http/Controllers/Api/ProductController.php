<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Lấy tất cả các sản phẩm
    public function index()
    {
        $products = Product::with(['category', 'brand', 'images'])->get();
        return response()->json($products);
    }

    // Lấy chi tiết một sản phẩm
    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'images', 'variants'])->findOrFail($id);
        return response()->json($product);
    }

    // Tạo mới một sản phẩm
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // Cập nhật một sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    // Xóa một sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
