<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Lấy tất cả các thương hiệu
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    // Lấy chi tiết một thương hiệu
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    // Tạo mới một thương hiệu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'logo' => 'required|string|max:255',
        ]);

        $brand = Brand::create($validated);
        return response()->json($brand, 201);
    }

    // Cập nhật một thương hiệu
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        $brand->update($validated);
        return response()->json($brand);
    }

    // Xóa một thương hiệu
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(null, 204);
    }
}
