@extends('admin.layout')
@section('title', 'Cập nhật sản phẩm')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="header-title">Cập nhật sản phẩm</h4>
        </div>
    </div>

    <!-- Hiển thị thông báo thành công -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('productupdate', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tên sản phẩm -->
        <div class="form-group mb-3">
            <label for="name">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <!-- Danh mục -->
        <div class="form-group mb-3">
            <label for="category_id">Danh mục</label>
            <select name="category_id" class="form-control" id="category_id" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Thương hiệu -->
        <div class="form-group mb-3">
            <label for="brand_id">Thương hiệu</label>
            <select name="brand_id" class="form-control" id="brand_id" required>
                @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Mô tả -->
        <div class="form-group mb-3">
            <label for="description">Mô tả</label>
            <textarea name="description" class="form-control" id="description" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Giá sản phẩm -->
        <div class="form-group mb-3">
            <label for="price">Giá</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="stock">Số lượng</label>
            <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <!-- Ảnh sản phẩm -->
        <div class="form-group mb-3">
            <label for="img">Ảnh sản phẩm</label>
            <input type="file" name="img" class="form-control" id="img">
            @if($product->variant_image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->variant_image) }}" alt="Ảnh sản phẩm" width="100px">
            </div>
            @endif
        </div>
        <!-- Các biến thể sản phẩm (Tùy chọn) -->
        <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
        <a href="{{ route('products') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection