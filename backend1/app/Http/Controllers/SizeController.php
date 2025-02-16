<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Http\Resources\SizeResource;

class SizeController extends Controller
{
    // Lấy danh sách kích thước (Public API)
    public function index()
    {
        $sizes = Size::orderBy('id', 'asc')->paginate(10);
        return SizeResource::collection($sizes);
    }

    // Xem chi tiết kích thước (Public API)
    public function show($id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message' => 'Kích thước không tồn tại!'], 404);
        }
        return new SizeResource($size);
    }

    // Admin tạo kích thước mới
    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string|max:255|unique:sizes,size',
        ]);

        $size = Size::create($request->all());

        return response()->json([
            'message' => 'Kích thước đã được tạo!',
            'size' => new SizeResource($size)
        ], 201);
    }

    // Admin cập nhật kích thước
    public function update(Request $request, $id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message' => 'Kích thước không tồn tại!'], 404);
        }

        $request->validate([
            'size' => 'required|string|max:255|unique:sizes,size,' . $id,
        ]);

        $size->update($request->all());

        return response()->json([
            'message' => 'Kích thước đã được cập nhật!',
            'size' => new SizeResource($size)
        ]);
    }

    // Admin xóa kích thước
    public function destroy($id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message' => 'Kích thước không tồn tại!'], 404);
        }

        $size->delete();
        return response()->json(['message' => 'Kích thước đã được xóa thành công!']);
    }
}
