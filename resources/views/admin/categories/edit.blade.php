@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Danh Mục
@endsection

@section('content')
    <div class="wrapper">
        <div class="container mt-5 ">
            <div class="card p-2">
                <h2 class="mb-4">Update Category</h2>
                <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $category->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <input type="checkbox" id="is_active" name="is_active" {{ $category->is_active ? 'checked' : '' }}>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection
