<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    // Hiển thị trang dashboard admin
    public function index()
    {
        return view('admin.dashboard');
    }

    // Hiển thị danh sách sản phẩm với tìm kiếm & phân trang
    public function products(Request $request)
    {
        $query = Product::orderBy('id', 'DESC');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'like', $searchTerm)
                ->orWhereHas('brand', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                })
                ->orWhereHas('category', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                });
        }

        $products = $query->paginate(10)->appends($request->query());
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    // Xử lý thêm sản phẩm
    public function productadd(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        // Xử lý upload ảnh
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('products', 'public');
            $product->variant_image = $imagePath;
        }

        $product->save();

        return redirect()->route('products')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Xóa sản phẩm
    public function productdelete($id)
    {
        $product = Product::findOrFail($id);

        // Xóa ảnh nếu có
        if ($product->variant_image) {
            Storage::disk('public')->delete($product->variant_image);
        }

        $product->delete();

        return redirect()->route('products')->with('success', 'Xóa sản phẩm thành công!');
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function productedit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // Cập nhật sản phẩm
    public function productupdate(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::findOrFail($id);
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        // Cập nhật ảnh sản phẩm
        if ($request->hasFile('img')) {
            // Xóa ảnh cũ nếu có
            if ($product->variant_image) {
                Storage::disk('public')->delete($product->variant_image);
            }

            $imagePath = $request->file('img')->store('products', 'public');
            $product->variant_image = $imagePath;
        }

        $product->save();

        return redirect()->route('products')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    // Hiển thị danh sách Brands
    public function brands(Request $request)
    {
        $query = Brand::orderBy('id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'like', $searchTerm);
        }

        $brands = $query->paginate(10)->appends($request->query());

        return view('admin.brands.index', compact('brands'));
    }

    // Thêm brand mới
    public function brandadd(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('brands')->with('success', 'Thêm thương hiệu thành công!');
    }

    // Xóa brand
    public function branddelete($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brands')->with('success', 'Xóa thương hiệu thành công!');
    }

    // Hiển thị form chỉnh sửa brand
    public function brandedit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand'));
    }

    // Cập nhật brand
    public function brandupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('brands')->with('success', 'Cập nhật thương hiệu thành công!');
    }
    // Hiển thị danh sách Categories
    public function categories(Request $request)
    {
        $query = Category::orderBy('id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'like', $searchTerm);
        }

        $categories = $query->paginate(10)->appends($request->query());

        return view('admin.categories.index', compact('categories'));
    }

    // Thêm category mới
    public function categoryadd(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories')->with('success', 'Thêm danh mục thành công!');
    }

    // Xóa category
    public function categorydelete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories')->with('success', 'Xóa danh mục thành công!');
    }

    // Hiển thị form chỉnh sửa category
    public function categoryedit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật category
    public function categoryupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories')->with('success', 'Cập nhật danh mục thành công!');
    }
    // Hiển thị danh sách Users
    public function users(Request $request)
    {
        $query = User::orderBy('id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm);
        }

        $users = $query->paginate(10)->appends($request->query());

        return view('admin.users.index', compact('users'));
    }

    public function useradd(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users')->with('success', 'Thêm người dùng thành công!');
    }

    // Xóa user
    public function userdelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'Xóa người dùng thành công!');
    }

    // Hiển thị form chỉnh sửa user
    public function useredit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // Cập nhật user
    public function userupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users')->with('success', 'Cập nhật người dùng thành công!');
    }
}
