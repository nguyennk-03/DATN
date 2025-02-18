<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    // Lấy tất cả các kích thước
    public function index()
    {
        $sizes = Size::all();

        return response()->json($sizes);
    }

    // Tạo mới một kích thước
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'size' => 'required|string|unique:sizes,size|max:50',
        ]);

        // Tạo mới một kích thước
        $size = Size::create([
            'size' => $validated['size'],
        ]);

        return response()->json($size, 201);
    }

    // Cập nhật kích thước
    public function update(Request $request, $sizeId)
    {
        $size = Size::findOrFail($sizeId);

        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'size' => 'required|string|unique:sizes,size,' . $size->id . '|max:50',
        ]);

        // Cập nhật kích thước
        $size->update([
            'size' => $validated['size'],
        ]);

        return response()->json($size);
    }

    // Xóa kích thước
    public function destroy($sizeId)
    {
        $size = Size::findOrFail($sizeId);

        // Xóa kích thước
        $size->delete();

        return response()->json(['message' => 'Kích thước đã được xóa.']);
    }
}
