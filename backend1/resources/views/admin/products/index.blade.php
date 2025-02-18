@extends('admin.layout')
@section('titlepage', 'Danh sách sản phẩm')
@section('content')

<div class="container-fluid">

    <!-- Start Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">StepViet</a></li>
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                </div>
                <h4 class="page-title">Sản Phẩm</h4>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Hiển thị thông báo -->
    @if (session('success'))
    <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Danh sách sản phẩm -->
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="header-title font-weight-bold mb-0">Danh Sách Sản Phẩm</h4>

                    <div class="d-flex align-items-center">
                        <!-- Form tìm kiếm -->
                        <form action="{{ route('products') }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary search-btn">Tìm</button>
                            </div>
                        </form>

                        <!-- Nút thêm sản phẩm -->
                        <button type="button" class="btn btn-success ms-3" data-bs-toggle="modal"
                            data-bs-target="#addProductModal">
                            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal thêm sản phẩm -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addProductLabel">Thêm Sản Phẩm</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('productadd') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="category_id">Danh mục</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="brand_id">Thương hiệu</label>
                                    <select name="brand_id" class="form-control" required>
                                        <option value="">Chọn thương hiệu</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="price">Giá</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="stock">Số lượng tồn</label>
                                    <input type="number" name="stock" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="img">Ảnh sản phẩm</label>
                                    <input type="file" name="img" class="form-control">
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary ms-2">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng danh sách sản phẩm -->
            <table id="product-table" class="table table-striped table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            <img src="{{ $item->variant_image ? asset('storage/' . $item->variant_image) : asset('default-image.jpg') }}"
                                width="80" class="rounded-md">
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $item->stock ?? '0' }}</td>
                        <td>{{ $item->category ? $item->category->name : 'Chưa có danh mục' }}</td>
                        <td>{{ $item->brand ? $item->brand->name : 'Chưa có thương hiệu' }}</td>
                        <td class="action-icons">
                            <a href="{{ route('productedit', $item->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('productdelete', $item->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="d-flex justify-content-between align-items-center " style="background-color: #343a40; color: #fff;">
                <div>
                    Hiển thị <strong>{{ $products->firstItem() }}</strong> đến <strong>{{ $products->lastItem() }}</strong> trong tổng số
                    <strong>{{ $products->total() }}</strong> sản phẩm
                </div>
                <div class="pagination-container">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection