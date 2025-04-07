@extends('admin.layouts.master')

@section('title')
    Thêm Mới Danh Mục
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="wrapper">
                <div class="container mt-5 ">
                    <div class="card p-2">
                        <h2 class="mb-4">Tạo Danh Mục Mới</h2>

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                            @csrf
                            <!-- Không cần hidden input vì đã có radio buttons -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="category_type_parent" name="category_type" value="parent" checked onclick="toggleParentCategoryDiv()">
                                    <label class="form-check-label" for="category_type_parent">
                                        Đây là danh mục cha
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="category_type_child" name="category_type" value="child" onclick="toggleParentCategoryDiv()">
                                    <label class="form-check-label" for="category_type_child">
                                        Đây là danh mục con
                                    </label>
                                </div>
                            </div>

                            <script>
                                function toggleParentCategoryDiv() {
                                    var parentRadio = document.getElementById('category_type_parent');
                                    var parentCategoryDiv = document.getElementById('parent_category_div');
                                    var parentIdSelect = document.getElementById('parent_id');

                                    if (parentRadio.checked) {
                                        parentCategoryDiv.style.display = 'none';
                                        if (parentIdSelect) parentIdSelect.value = '';
                                    } else {
                                        parentCategoryDiv.style.display = 'block';
                                    }
                                }

                                // Run on page load
                                document.addEventListener('DOMContentLoaded', function() {
                                    toggleParentCategoryDiv();
                                });
                            </script>

                            <div class="mb-3" id="parent_category_div" style="display: none;">
                                <label for="parent_id" class="form-label">Danh mục cha <span class="text-danger">*</span></label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">-- Chọn danh mục cha --</option>
                                    @foreach($parentCategories as $parentCategory)
                                        <option value="{{ $parentCategory->category_id }}">{{ $parentCategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="checkbox" id="is_active" name="is_active" value="single" checked>
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

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Document ready');

        // Lấy các phần tử
        var parentRadio = document.getElementById('category_type_parent');
        var childRadio = document.getElementById('category_type_child');
        var parentCategoryDiv = document.getElementById('parent_category_div');
        var parentIdSelect = document.getElementById('parent_id');
        var categoryForm = document.getElementById('categoryForm');

        // Xử lý sự kiện change cho radio buttons
        function handleRadioChange() {
            console.log('Radio changed');
            if (parentRadio.checked) {
                console.log('Parent radio selected');
                parentCategoryDiv.style.display = 'none';
                if (parentIdSelect) parentIdSelect.value = '';
            } else if (childRadio.checked) {
                console.log('Child radio selected');
                parentCategoryDiv.style.display = 'block';
            }
        }

        // Đăng ký sự kiện change
        if (parentRadio) parentRadio.addEventListener('change', handleRadioChange);
        if (childRadio) childRadio.addEventListener('change', handleRadioChange);

        // Kiểm tra trạng thái ban đầu
        handleRadioChange();

        // Validation khi submit form
        if (categoryForm) {
            categoryForm.addEventListener('submit', function(e) {
                if (childRadio.checked && (!parentIdSelect || !parentIdSelect.value)) {
                    e.preventDefault();
                    alert('Vui lòng chọn danh mục cha cho danh mục con!');
                    return false;
                }
            });
        }

        // Debug
        console.log('parentRadio exists:', !!parentRadio);
        console.log('childRadio exists:', !!childRadio);
        console.log('parentCategoryDiv exists:', !!parentCategoryDiv);
        console.log('parentIdSelect exists:', !!parentIdSelect);
        console.log('categoryForm exists:', !!categoryForm);
        if (parentCategoryDiv) console.log('parentCategoryDiv display:', parentCategoryDiv.style.display);
        if (parentRadio) console.log('parentRadio checked:', parentRadio.checked);
        if (childRadio) console.log('childRadio checked:', childRadio.checked);
    });
</script>
@endsection