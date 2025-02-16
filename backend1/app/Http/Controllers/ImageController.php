<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Resources\ImageResource;

class ImageController extends Controller
{
    // Lấy danh sách hình ảnh (Public API)
    public function index()
    {
        $images = Image::orderBy('id', 'asc')->paginate(10);
        return ImageResource::collection($images);
    }

    // Xem chi tiết hình ảnh (Public API)
    public function show($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['message' => 'Hình ảnh không tồn tại!'], 404);
        }
        return new ImageResource($image);
    }

    // Admin tạo hình ảnh mới
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_url' => 'required|string|url|max:255',
        ]);

        $image = Image::create($request->all());

        return response()->json([
            'message' => 'Hình ảnh đã được tạo!',
            'image' => new ImageResource($image)
        ], 201);
    }

    // Admin cập nhật hình ảnh
    public function update(Request $request, $id)
    {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['message' => 'Hình ảnh không tồn tại!'], 404);
        }

        $request->validate([
            'image_url' => 'required|string|url|max:255',
        ]);

        $image->update($request->all());

        return response()->json([
            'message' => 'Hình ảnh đã được cập nhật!',
            'image' => new ImageResource($image)
        ]);
    }

    // Admin xóa hình ảnh
    public function destroy($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['message' => 'Hình ảnh không tồn tại!'], 404);
        }

        $image->delete();
        return response()->json(['message' => 'Hình ảnh đã được xóa thành công!']);
    }
}
