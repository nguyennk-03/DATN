<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    // Lấy tất cả các màu sắc
    public function index()
    {
        $colors = Color::all();
        return response()->json($colors);
    }

    // Lấy chi tiết một màu sắc
    public function show($id)
    {
        $color = Color::findOrFail($id);
        return response()->json($color);
    }

    // Tạo mới một màu sắc
    public function store(Request $request)
    {
        $validated = $request->validate([
            'color_name' => 'required|string|max:255',
        ]);

        $color = Color::create($validated);
        return response()->json($color, 201);
    }

    // Cập nhật một màu sắc
    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $validated = $request->validate([
            'color_name' => 'required|string|max:255',
        ]);

        $color->update($validated);
        return response()->json($color);
    }

    // Xóa một màu sắc
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return response()->json(null, 204);
    }
}
