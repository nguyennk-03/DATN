@extends('admin.layout')

@section('title', 'Danh sách người dùng')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="header-title">Danh sách người dùng</h4>
        </div>
    </div>

    <!-- Hiển thị thông báo thành công -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Bảng danh sách người dùng -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="header-title font-weight-bold mb-0">Danh Sách Người Dùng</h4>

                    <div class="d-flex align-items-center">
                        <!-- Form tìm kiếm -->
                        <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input" placeholder="Tìm kiếm người dùng..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary search-btn">Tìm</button>
                            </div>
                        </form>

                        <!-- Nút thêm người dùng -->
                        <a href="{{ route('useradd') }}" class="btn btn-success ms-3">
                            <i class="bi bi-plus-circle"></i> Thêm người dùng
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bảng dữ liệu người dùng -->
            <table id="user-table" class="table dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" width="50" class="rounded-circle">
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'Chưa có' }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="action-icons">
                            <a href="{{ route('useredit', $user->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('userdelete', $user->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="d-flex justify-content-between align-items-center " style="background-color: #343a40; color: #fff;">
                <div>
                    Hiển thị <strong>{{ $users->firstItem() }}</strong> đến <strong>{{ $users->lastItem() }}</strong> trong tổng số
                    <strong>{{ $users->total() }}</strong> sản phẩm
                </div>
                <div class="pagination-container">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection