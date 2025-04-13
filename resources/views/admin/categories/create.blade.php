@extends('admin.layouts.master')

@section('title')
    Thêm Mới Danh Mục
@endsection

@section('css')

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
</style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="wrapper">
                <div class="container mt-5 ">
                    <div class="card p-4">
                        <h2 class="mb-4">Tạo Danh Mục Mới</h2>
                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                            @csrf
                            <input type="hidden" name="category_type" value="parent">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên danh mục chính</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" id="is_active" name="is_active" value="single" checked>
                                            <label for="is_active">Kích hoạt</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title">Danh mục con</div>
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

                            <script>
                            // Biến đếm toàn cục cho các danh mục con mới
                            var newChildCount = 0;
                            var existingChildCount = 0;

                            // Hàm thêm danh mục con từ danh mục có sẵn
                            function addExistingChildCategory() {
                                console.log('Function addExistingChildCategory called');
                                var container = document.getElementById('existing-child-categories-container');
                                console.log('Container found:', !!container);

                                if (!container) {
                                    console.error('Container #existing-child-categories-container not found!');
                                    return;
                                }

                                var childIndex = existingChildCount++;
                                console.log('Creating child with index:', childIndex);

                                var html = '<div class="child-category-item">' +
                                    '<div class="row">' +
                                        '<div class="col-md-10">' +
                                            '<label for="existing_child_' + childIndex + '" class="form-label">Chọn danh mục con</label>' +
                                            '<select class="form-control" id="existing_child_' + childIndex + '" name="existing_children[]">' +
                                                '<option value="">-- Chọn danh mục --</option>' +
                                                '@foreach($availableChildCategories as $childCategory)' +
                                                    '<option value="{{ $childCategory->category_id }}">{{ $childCategory->name }}</option>' +
                                                '@endforeach' +
                                            '</select>' +
                                        '</div>' +
                                        '<div class="col-md-2">' +
                                            '<button type="button" class="btn btn-danger" style="margin-top: 30px;" onclick="this.parentNode.parentNode.parentNode.remove()">' +
                                                '<i class="fa fa-trash"></i> Xóa' +
                                            '</button>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';

                                container.innerHTML += html;
                                console.log('Child element added to container');
                            }

                            // Hàm thêm danh mục con mới
                            function addNewChildCategory() {
                                console.log('Function addNewChildCategory called');
                                var container = document.getElementById('new-child-categories-container');
                                console.log('Container found:', !!container);

                                if (!container) {
                                    console.error('Container #new-child-categories-container not found!');
                                    return;
                                }

                                var childIndex = newChildCount++;
                                console.log('Creating child with index:', childIndex);

                                // Tạo phần tử mới thay vì sử dụng innerHTML
                                var childItem = document.createElement('div');
                                childItem.className = 'child-category-item';

                                // Tạo nội dung HTML cho phần tử mới
                                childItem.innerHTML =
                                    '<div class="row">' +
                                        '<div class="col-md-8">' +
                                            '<label for="new_child_name_' + childIndex + '" class="form-label">Tên danh mục con mới</label>' +
                                            '<input type="text" class="form-control" id="new_child_name_' + childIndex + '" name="new_children[' + childIndex + '][name]" required>' +
                                        '</div>' +
                                        '<div class="col-md-2">' +
                                            '<div class="form-check" style="margin-top: 30px;">' +
                                                '<input type="checkbox" id="new_child_active_' + childIndex + '" name="new_children[' + childIndex + '][is_active]" value="1" checked>' +
                                                '<label for="new_child_active_' + childIndex + '">Kích hoạt</label>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="col-md-2">' +
                                            '<button type="button" class="btn btn-danger remove-btn" style="margin-top: 30px;">' +
                                                '<i class="fa fa-trash"></i> Xóa' +
                                            '</button>' +
                                        '</div>' +
                                    '</div>';

                                // Thêm phần tử vào container
                                container.appendChild(childItem);
                                console.log('Child element added to container');

                                // Thêm sự kiện xóa cho nút xóa
                                var removeBtn = childItem.querySelector('.remove-btn');
                                console.log('Remove button found:', !!removeBtn);

                                if (removeBtn) {
                                    removeBtn.addEventListener('click', function() {
                                        console.log('Remove button clicked');
                                        container.removeChild(childItem);
                                    });
                                }
                            }
                            </script>



                            <div class="mt-4">
                                <br>
                                <button type="submit" class="btn btn-primary">Lưu danh mục</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('categoryForm').onsubmit = function(e) {
            var name = document.getElementById('name').value.trim();
            if (!name) {
                e.preventDefault();
                alert('Vui lòng nhập tên danh mục chính!');
                return false;
            }
        };
    });
</script>
@endsection
