<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // Lấy tất cả hình ảnh của sản phẩm
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $images = $product->images;  // Quan hệ images() trong model Product
        return response()->json($images);
    }

    // Tải lên hình ảnh cho sản phẩm
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Lưu trữ hình ảnh
        $imagePath = $request->file('image')->store('images', 'public');

        // Tạo bản ghi hình ảnh
        $image = $product->images()->create([
            'image_url' => $imagePath,
        ]);

        return response()->json($image, 201);
    }

    // Xóa hình ảnh
    public function destroy($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);

        // Xóa hình ảnh trong hệ thống
        Storage::disk('public')->delete($image->image_url);

        // Xóa bản ghi hình ảnh trong cơ sở dữ liệu
        $image->delete();

        return response()->json(null, 204);
    }
}
