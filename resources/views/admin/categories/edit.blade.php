@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Danh Mục
@endsection

@section('css')
@if($category->parent_id === null)
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .child-category-item {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .child-category-item .btn-remove {
        margin-left: 10px;
    }
    .select2-container {
        width: 100% !important;
    }
    #add-existing-child-btn, #add-new-child-btn {
        margin-bottom: 15px;
    }
    .section-title {
        margin-top: 20px;
        margin-bottom: 15px;
        font-weight: bold;
        color: #333;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }
    .current-child-category {
        background-color: #e9f7fe;
        border: 1px solid #cce5ff;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>
@endif
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="wrapper">
                <div class="container mt-5 ">
                    <div class="card p-4">
                        <h2 class="mb-4">Cập Nhật Danh Mục</h2>


                        @if($category->parent_id === null)
                        <!-- Chỉnh sửa danh mục cha -->
                        <script>
                        // Biến đếm cho các danh mục con mới
                        let newChildCount = 0;
                        let existingChildCount = 0;

                        // Khởi tạo Select2 cho các select box
                        function initSelect2() {
                            $('.select2-child-categories').select2({
                                placeholder: 'Chọn danh mục con',
                                allowClear: true
                            });
                        }

                        // Thêm danh mục con từ danh mục có sẵn
                        function addExistingChildCategory() {
                            console.log('Function addExistingChildCategory called');
                            const container = document.getElementById('existing-child-categories-container');
                            console.log('Container found:', !!container);

                            if (!container) {
                                console.error('Container #existing-child-categories-container not found!');
                                return;
                            }

                            const childIndex = existingChildCount++;
                            console.log('Creating child with index:', childIndex);

                            const childItem = document.createElement('div');
                            childItem.className = 'child-category-item';
                            childItem.innerHTML = `
                                <div class="row">
                                    <div class="col-md-10">
                                        <label for="existing_child_${childIndex}" class="form-label">Chọn danh mục con</label>
                                        <select class="form-control select2-child-categories" id="existing_child_${childIndex}" name="existing_children[]">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($availableChildCategories as $childCat)
                                                <option value="{{ $childCat->category_id }}">{{ $childCat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-remove" style="margin-top: 30px;">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            `;

                            container.appendChild(childItem);
                            console.log('Child element added to container');

                            // Khởi tạo Select2 cho select box mới thêm
                            initSelect2();

                            // Xử lý sự kiện xóa
                            childItem.querySelector('.btn-remove').addEventListener('click', function() {
                                console.log('Remove button clicked');
                                container.removeChild(childItem);
                            });
                        }

                        // Thêm danh mục con mới
                        function addNewChildCategory() {
                            console.log('Function addNewChildCategory called');
                            const container = document.getElementById('new-child-categories-container');
                            console.log('Container found:', !!container);

                            if (!container) {
                                console.error('Container #new-child-categories-container not found!');
                                return;
                            }

                            const childIndex = newChildCount++;
                            console.log('Creating child with index:', childIndex);

                            const childItem = document.createElement('div');
                            childItem.className = 'child-category-item';
                            childItem.innerHTML = `
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="new_child_name_${childIndex}" class="form-label">Tên danh mục con mới</label>
                                        <input type="text" class="form-control" id="new_child_name_${childIndex}" name="new_children[${childIndex}][name]" required>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check" style="margin-top: 30px;">
                                            <input type="checkbox" id="new_child_active_${childIndex}" name="new_children[${childIndex}][is_active]" value="1" checked>
                                            <label for="new_child_active_${childIndex}">Kích hoạt</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-remove" style="margin-top: 30px;">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            `;

                            container.appendChild(childItem);
                            console.log('Child element added to container');

                            // Xử lý sự kiện xóa
                            childItem.querySelector('.btn-remove').addEventListener('click', function() {
                                console.log('Remove button clicked');
                                container.removeChild(childItem);
                            });
                        }
                        </script>
                        <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category_type" value="parent">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên danh mục chính</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" id="is_active" name="is_active" value="single" {{ $category->is_active ? 'checked' : '' }}>
                                            <label for="is_active">Kích hoạt</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title">Danh mục con hiện tại</div>
                            <div id="current-child-categories-container">
                                @if($childCategories->count() > 0)
                                    @foreach($childCategories as $childCategory)
                                    <div class="current-child-category">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong>{{ $childCategory->name }}</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="badge {{ $childCategory->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $childCategory->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                                </span>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" id="remove_child_{{ $childCategory->category_id }}"
                                                           name="remove_children[]" value="{{ $childCategory->category_id }}">
                                                    <label for="remove_child_{{ $childCategory->category_id }}">Gỡ bỏ</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">Chưa có danh mục con nào.</p>
                                @endif
                            </div>

                            <div class="section-title">Thêm danh mục con mới</div>
                            <p class="text-muted">Bạn có thể thêm danh mục con cho danh mục chính này.</p>

                            <!-- Thêm danh mục con từ danh mục có sẵn -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-info" onclick="addExistingChildCategory()">
                                    <i class="fa fa-plus-circle"></i> Thêm danh mục con từ danh mục có sẵn
                                </button>

                                <div id="existing-child-categories-container">
                                    <!-- Các danh mục con được thêm vào đây -->
                                </div>
                            </div>

                            <!-- Tạo danh mục con mới -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" onclick="addNewChildCategory()">
                                    <i class="fa fa-plus-circle"></i> Tạo danh mục con mới
                                </button>

                                <div id="new-child-categories-container">
                                    <!-- Các danh mục con mới được thêm vào đây -->
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Lưu danh mục</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                        @else
                        <!-- Chỉnh sửa danh mục con -->
                        <form action="{{ route('categories.update', $category) }}" method="POST"
                            enctype="multipart/form-data" id="categoryForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category_type" value="child">

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $category->name }}">
                            </div>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Danh mục cha <span class="text-danger">*</span></label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">-- Chọn danh mục cha --</option>
                                    @foreach($parentCategories as $parentCategory)
                                        <option value="{{ $parentCategory->category_id }}" {{ $category->parent_id == $parentCategory->category_id ? 'selected' : '' }}>
                                            {{ $parentCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@if($category->parent_id === null)
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation khi submit form
        const categoryForm = document.getElementById('categoryForm');
        if (categoryForm) {
            categoryForm.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                if (!name) {
                    e.preventDefault();
                    alert('Vui lòng nhập tên danh mục chính!');
                    return false;
                }
            });
        }
    });
</script>
@else
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation khi submit form
        const categoryForm = document.getElementById('categoryForm');
        const parentIdSelect = document.getElementById('parent_id');

        if (categoryForm) {
            categoryForm.addEventListener('submit', function(e) {
                if (!parentIdSelect || !parentIdSelect.value) {
                    e.preventDefault();
                    alert('Vui lòng chọn danh mục cha cho danh mục con!');
                    return false;
                }
            });
        }
    });
</script>
@endif
@endsection