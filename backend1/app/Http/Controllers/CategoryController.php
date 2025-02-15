<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    //  Lấy danh sách danh mục (Public API)
    public function index()
    {
        $categories = Category::orderBy('id','esc' )->get();
        return response()->json(['categories' => $categories]);
    }

    //  Xem chi tiết danh mục (Public API)
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại!'], 404);
        }
        return response()->json(['category' => $category]);
    }

    //  Admin tạo danh mục mới
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $category = Category::create($request->all());

        return response()->json([
            'message' => 'Danh mục đã được tạo!',
            'category' => $category
        ], 201);
    }

    //  Admin cập nhật danh mục
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|unique:categories,name,' . $id . '|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $category->update($request->all());

        return response()->json([
            'message' => 'Danh mục đã được cập nhật!',
            'category' => $category
        ]);
    }

    //  Admin xóa danh mục
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
