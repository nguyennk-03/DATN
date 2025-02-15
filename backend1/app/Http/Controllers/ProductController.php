<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    use AuthorizesRequests;

    // Lấy danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::with(['variants.size', 'variants.color', 'images']);

        // Tìm kiếm theo tên sản phẩm
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo thương hiệu
        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Lọc theo khoảng giá
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        return response()->json($query->get());
    }

    // Lấy chi tiết 1 sản phẩm theo ID
    public function show($id)
    {
        $product = Product::with(['variants.size', 'variants.color', 'images'])->findOrFail($id);
        return response()->json($product);
    }

    // Lấy chi tiết 1 sản phẩm theo Slug
    public function showBySlug($slug)
    {
        $product = Product::with(['variants.size', 'variants.color', 'images'])->where('slug', $slug)->firstOrFail();
        return response()->json($product);
    }

    // Thêm sản phẩm (Chỉ Admin)
    public function store(Request $request)
    {
        $this->authorize('admin'); // Chỉ admin mới có quyền

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $product = Product::create($request->all());

        return response()->json(['message' => 'Sản phẩm đã được tạo!', 'product' => $product], 201);
    }

    // Cập nhật sản phẩm (Chỉ Admin)
    public function update(Request $request, $id)
    {
        $this->authorize('admin'); // Chỉ admin mới có quyền

        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|max:255|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $product->update($request->all());

        return response()->json(['message' => 'Sản phẩm đã được cập nhật!', 'product' => $product]);
    }

    // Xóa sản phẩm (Chỉ Admin)
    public function destroy($id)
    {
        $this->authorize('admin'); // Chỉ admin mới có quyền

        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Sản phẩm đã bị xóa!']);
    }
}