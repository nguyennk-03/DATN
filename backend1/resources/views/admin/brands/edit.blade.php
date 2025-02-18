@extends('admin.layout')
@section('title', 'Cập nhật Thương hiệu')

@section('content')
<div class="container-fluid">
    <h4 class="header-title">Cập nhật Thương hiệu</h4>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('brandupdate', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Tên thương hiệu</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('brands') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
