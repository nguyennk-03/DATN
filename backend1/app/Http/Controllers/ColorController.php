<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Http\Resources\ColorResource;

class ColorController extends Controller
{
    // Lấy danh sách màu sắc (Public API)
    public function index()
    {
        $colors = Color::orderBy('id', 'asc')->paginate(10);
        return ColorResource::collection($colors);
    }

    // Xem chi tiết màu sắc (Public API)
    public function show($id)
    {
        $color = Color::find($id);
        if (!$color) {
            return response()->json(['message' => 'Màu sắc không tồn tại!'], 404);
        }
        return new ColorResource($color);
    }

    // Admin tạo màu sắc mới
    public function store(Request $request)
    {
        $request->validate([
            'color_name' => 'required|string|max:255|unique:colors,color_name',
        ]);

        $color = Color::create($request->all());

        return response()->json([
            'message' => 'Màu sắc đã được tạo!',
            'color' => new ColorResource($color)
        ], 201);
    }

    // Admin cập nhật màu sắc
    public function update(Request $request, $id)
    {
        $color = Color::find($id);
        if (!$color) {
            return response()->json(['message' => 'Màu sắc không tồn tại!'], 404);
        }

        $request->validate([
            'color_name' => 'required|string|max:255|unique:colors,color_name,' . $id,
        ]);

        $color->update($request->all());

        return response()->json([
            'message' => 'Màu sắc đã được cập nhật!',
            'color' => new ColorResource($color)
        ]);
    }

    // Admin xóa màu sắc
    public function destroy($id)
    {
        $color = Color::find($id);
        if (!$color) {
            return response()->json(['message' => 'Màu sắc không tồn tại!'], 404);
        }

        $color->delete();
        return response()->json(['message' => 'Màu sắc đã được xóa thành công!']);
    }
}
