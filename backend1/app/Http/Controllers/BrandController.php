<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandController extends Controller
{
    //  Lấy danh sách thương hiệu (Public API)
    public function index()
    {
        $brands = Brand::orderBy('id', 'asc')->get();
        return response()->json(['brands' => $brands]);
    }

    //  Xem chi tiết thương hiệu (Public API)
    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Thương hiệu không tồn tại!'], 404);
        }
        return response()->json(['brand' => $brand]);
    }

    //  Admin tạo thương hiệu mới
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:brands,name|max:255',
            'slug' => 'required|string|unique:brands,slug|max:255',
            'logo' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $brand = Brand::create($request->all());

        return response()->json([
            'message' => 'Thương hiệu đã được tạo!',
            'brand' => $brand
        ], 201);
    }

    //  Admin cập nhật thương hiệu
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Thương hiệu không tồn tại!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|unique:brands,name,' . $id . '|max:255',
            'slug' => 'string|unique:brands,slug,' . $id . '|max:255',
            'logo' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $brand->update($request->all());

        return response()->json([
            'message' => 'Thương hiệu đã được cập nhật!',
            'brand' => $brand
        ]);
    }

    //  Admin xóa thương hiệu
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Thương hiệu không tồn tại!'], 404);
        }

        $brand->delete();
        return response()->json(['message' => 'Thương hiệu đã được xóa thành công!']);
    }
}
