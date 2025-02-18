@extends('admin.layout')

@section('title', 'Cập nhật người dùng')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="header-title">Cập nhật người dùng</h4>
        </div>
    </div>

    <!-- Hiển thị thông báo thành công -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('userupdate', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tên người dùng -->
        <div class="form-group mb-3">
            <label for="name">Tên người dùng</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email -->
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Số điện thoại -->
        <div class="form-group mb-3">
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <!-- Vai trò -->
        <div class="form-group mb-3">
            <label for="role">Vai trò</label>
            <select name="role" class="form-control" id="role" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <!-- Avatar -->
        <div class="form-group mb-3">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" class="form-control" id="avatar">
            @if($user->avatar)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="100px">
            </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Cập nhật người dùng</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection