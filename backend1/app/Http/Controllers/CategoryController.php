<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    // Lấy danh sách danh mục (Public API)
    public function index()
    {
        $categories = Category::orderBy('id', 'asc')->paginate(10); 
        return CategoryResource::collection($categories);
    }

    // Xem chi tiết danh mục (Public API)
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại!'], 404);
        }
        return new CategoryResource($category);
    }

    // Admin tạo danh mục mới
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json([
            'message' => 'Danh mục đã được tạo!',
            'category' => new CategoryResource($category)
        ], 201);
    }

    // Admin cập nhật danh mục
    public function update(StoreCategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại!'], 404);
        }

        $category->update($request->validated());
        return response()->json([
            'message' => 'Danh mục đã được cập nhật!',
            'category' => new CategoryResource($category)
        ]);
    }

    // Admin xóa danh mục
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại!'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Danh mục đã được xóa thành công!']);
    }
}
