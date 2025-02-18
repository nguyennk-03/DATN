@extends('admin.layout')
@section('title', 'Cập nhật Danh mục')

@section('content')
<div class="container-fluid">
    <h4 class="header-title">Cập nhật Danh mục</h4>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('categoryupdate', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('categories') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
