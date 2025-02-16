<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Resources\BrandResource;
use App\Http\Requests\StoreBrandRequest;

class BrandController extends Controller
{
    //  Lấy danh sách thương hiệu (Public API)
    public function index()
    {
        $brands = Brand::orderBy('id', 'asc')->paginate(10);
        return BrandResource::collection($brands);
    }

    //  Xem chi tiết thương hiệu (Public API)
    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Thương hiệu không tồn tại!'], 404);
        }
        return new BrandResource($brand);
    }

    //  Admin tạo thương hiệu mới
    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create($request->validated());
        return response()->json([
            'message' => 'Thương hiệu đã được tạo!',
            'brand' => new BrandResource($brand)
        ], 201);
    }

    //  Admin cập nhật thương hiệu
    public function update(StoreBrandRequest $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Thương hiệu không tồn tại!'], 404);
        }

        $brand->update($request->validated());
        return response()->json([
            'message' => 'Thương hiệu đã được cập nhật!',
            'brand' => new BrandResource($brand)
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
