@extends('admin.layouts.master')

@section('title')
    Thêm Mới Danh Mục
@endsection

@section('content')
    <div class="wrapper">
        <div class="container mt-5 ">
            <div class="card p-2">
                <h2 class="mb-4">Create New Category</h2>
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <input type="checkbox" name="is_active" checked>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection