@extends('admin.layout')
@section('titlepage', 'Danh sách Danh Mục')
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
                        <li class="breadcrumb-item active">Danh Mục</li>
                    </ol>
                </div>
                <h4 class="page-title">Danh Mục</h4>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Hiển thị thông báo -->
    @if (session('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Danh sách danh mục -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="header-title font-weight-bold mb-0">Danh Sách Danh Mục</h4>

                    <div class="d-flex align-items-center">
                        <!-- Form tìm kiếm -->
                        <form action="{{ route('categories') }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Tìm kiếm danh mục..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary search-btn">Tìm</button>
                            </div>
                        </form>

                        <!-- Nút thêm danh mục -->
                        <a href="{{ route('categoryadd') }}" class="btn btn-success ms-3">
                            <i class="bi bi-plus-circle"></i> Thêm Danh Mục
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bảng danh sách danh mục -->
            <table id="category-table" class="table dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Danh Mục</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td class="action-icons">
                            <a href="{{ route('categoryedit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('categorydelete', $category->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="d-flex justify-content-between">
                <div>
                    Hiển thị {{ $categories->firstItem() }} đến {{ $categories->lastItem() }} trong tổng số
                    {{ $categories->total() }} danh mục
                </div>
                <div>
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
