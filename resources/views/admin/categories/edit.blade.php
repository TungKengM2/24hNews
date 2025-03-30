@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Danh Mục
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="wrapper">
                <div class="container mt-5 ">
                    <div class="card p-2">
                        <h2 class="mb-4">Cập Nhật Danh Mục</h2>
                        <form action="{{ route('categories.update', $category) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $category->name }}">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="checkbox" id="is_active" name="is_active" value="single"
                                            {{ $category->is_active ? 'checked' : '' }}>
                                        <label for="is_active">Kích hoạt</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
