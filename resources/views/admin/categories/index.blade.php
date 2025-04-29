@extends('admin.layouts.master')

@section('title')
    Danh Sách Danh Mục
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .toggle-children {
        display: inline-block;
        width: 20px;
        text-align: center;
        margin-right: 5px;
    }
    .badge-secondary {
        background-color: #6c757d;
    }
    .badge-info {
        background-color: #17a2b8;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-danger {
        background-color: #dc3545;
    }
    .badge-primary {
        background-color: #007bff;
    }
</style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Danh Sách Danh Mục</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Danh Mục</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <div class="container-full">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <button type="button" class="waves-effect waves-light btn btn-default mb-5">
                                        <a href="{{ route('admin.dashboard') }}">
                                            Quay lại
                                        </a>
                                    </button>
                                    <button type="button" class="waves-effect waves-light btn btn-primary mb-5 h-40">
                                        <a href="{{ route('categories.create') }}">
                                            <i class="si-plus si"></i>
                                        </a>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm danh mục...">
                                        <div class="input-group-append">
                                            <select class="form-control" style="width: auto;" id="filterStatus">
                                                <option value="all">Tất cả trạng thái</option>
                                                <option value="active">Hoạt động</option>
                                                <option value="inactive">Không hoạt động</option>
                                            </select>
                                            <select class="form-control ml-2" style="width: auto;" id="filterType">
                                                <option value="all">Tất cả loại</option>
                                                <option value="parent">Danh mục cha</option>
                                                <option value="child">Danh mục con</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="complex_header" class="table table-striped table-bordered display"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Tên danh mục</th>
                                            <th scope="col">Đường dẫn</th>
                                            <th scope="col">Loại</th>
                                            <th scope="col">Danh mục cha</th>
                                            <th scope="col">Bài viết</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Kiểm duyệt viên</th>
                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Hiển thị danh mục cha trước --}}
                                        @foreach ($categories as $parentCategory)
                                            <tr class="bg-light parent-row" id="parent-{{ $parentCategory->category_id }}">
                                                <td scope="row">{{ $parentCategory->category_id }}</td>
                                                <td>
                                                    @php
                                                        $childCount = $childCategories->where('parent_id', $parentCategory->category_id)->count();
                                                    @endphp
                                                    @if($childCount > 0)
                                                        <span class="toggle-children" data-parent="{{ $parentCategory->category_id }}" style="cursor: pointer;">
                                                            <i class="fa fa-minus-square toggle-icon"></i>
                                                        </span>
                                                    @else
                                                        <span style="padding-left: 16px;"></span>
                                                    @endif
                                                    <strong>{{ $parentCategory->name }}</strong>
                                                    @if($childCount > 0)
                                                        <span class="badge badge-pill badge-secondary">{{ $childCount }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $parentCategory->slug }}</td>
                                                <td><span class="badge badge-primary">Danh mục cha</span></td>
                                                <td>-</td>
                                                <td>
                                                    @php
                                                        $articleCount = $parentCategory->articles->count();
                                                        $subArticleCount = 0;
                                                        foreach($childCategories->where('parent_id', $parentCategory->category_id) as $child) {
                                                            $subArticleCount += $child->subArticles->count();
                                                        }
                                                        $totalArticles =  $subArticleCount;
                                                    @endphp
                                                    <span class="badge badge-pill badge-info">{{ $totalArticles }}</span>
                                                </td>
                                                <td>
                                                    @if($parentCategory->is_active)
                                                        <span class="badge badge-success">Hoạt động</span>
                                                    @else
                                                        <span class="badge badge-danger">Không hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($parentCategory->moderator)
                                                        <span class="badge badge-info">{{ $parentCategory->moderator->username }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">Chưa gán</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex">
                                                    <a class="btn btn-warning me-2 h-40"
                                                        href="{{ route('categories.edit', $parentCategory) }}">
                                                        <i class="si-pencil si"></i>
                                                    </a>
                                                    <form action="{{ route('categories.destroy', $parentCategory) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger h-40"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xoá không?')"
                                                            type="submit">
                                                            <i class="si-trash si"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            {{-- Hiển thị danh mục con của danh mục cha này --}}
                                            @foreach ($childCategories->where('parent_id', $parentCategory->category_id) as $childCategory)
                                                <tr class="child-row child-of-{{ $parentCategory->category_id }}">
                                                    <td scope="row">{{ $childCategory->category_id }}</td>
                                                    <td style="padding-left: 40px;">&#8627; {{ $childCategory->name }}</td>
                                                    <td>{{ $childCategory->slug }}</td>
                                                    <td><span class="badge badge-info">Danh mục con</span></td>
                                                    <td>{{ $childCategory->parent->name }}</td>
                                                    <td>
                                                        @php
                                                            $articleCount = $childCategory->subArticles->count();
                                                        @endphp
                                                        <span class="badge badge-pill badge-info">{{ $articleCount }}</span>
                                                    </td>
                                                    <td>
                                                        @if($childCategory->is_active)
                                                            <span class="badge badge-success">Hoạt động</span>
                                                        @else
                                                            <span class="badge badge-danger">Không hoạt động</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $moderator = $childCategory->getModerator();
                                                        @endphp
                                                        @if($moderator)
                                                            <span class="badge badge-info">{{ $moderator->username }}</span>
{{--                                                            @if(!$childCategory->moderator_id)--}}
{{--                                                                <small class="text-muted d-block">(Kế thừa từ cha)</small>--}}
{{--                                                            @endif--}}
                                                        @else
                                                            <span class="badge badge-secondary">Chưa gán</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex">
                                                        <a class="btn btn-warning me-2 h-40"
                                                            href="{{ route('categories.edit', $childCategory) }}">
                                                            <i class="si-pencil si"></i>
                                                        </a>
                                                        <form action="{{ route('categories.destroy', $childCategory) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger h-40"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xoá không?')"
                                                                type="submit">
                                                                <i class="si-trash si"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        @include('admin.layouts.partials.footer')

        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');

    // Xử lý sự kiện click vào nút mở rộng/thu gọn
    var toggleButtons = document.querySelectorAll('.toggle-children');
    console.log('Toggle buttons found:', toggleButtons.length);

    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            console.log('Toggle button clicked');
            var parentId = this.getAttribute('data-parent');
            var childRows = document.querySelectorAll('.child-of-' + parentId);
            var toggleIcon = this.querySelector('.toggle-icon');

            console.log('Parent ID:', parentId);
            console.log('Child rows found:', childRows.length);

            // Kiểm tra trạng thái hiện tại của hàng con đầu tiên
            var isVisible = childRows.length > 0 && (childRows[0].style.display !== 'none');
            // Nếu style.display là chuỗi rỗng, có nghĩa là mặc định hiển thị
            if (childRows.length > 0 && childRows[0].style.display === '') {
                isVisible = true;
            }
            console.log('Is visible:', isVisible);

            // Đổi trạng thái hiển thị
            childRows.forEach(function(row) {
                row.style.display = isVisible ? 'none' : 'table-row';
            });

            // Đổi biểu tượng
            if (isVisible) {
                toggleIcon.classList.remove('fa-minus-square');
                toggleIcon.classList.add('fa-plus-square');
            } else {
                toggleIcon.classList.remove('fa-plus-square');
                toggleIcon.classList.add('fa-minus-square');
            }
        });
    });

    // Xử lý tìm kiếm và lọc
    var searchInput = document.getElementById('searchInput');
    var filterStatus = document.getElementById('filterStatus');
    var filterType = document.getElementById('filterType');

    console.log('Search input:', searchInput);
    console.log('Filter status:', filterStatus);
    console.log('Filter type:', filterType);

    function filterTable() {
        console.log('Filtering table');
        var searchText = searchInput ? searchInput.value.toLowerCase() : '';
        var statusFilter = filterStatus ? filterStatus.value : 'all';
        var typeFilter = filterType ? filterType.value : 'all';

        console.log('Search text:', searchText);
        console.log('Status filter:', statusFilter);
        console.log('Type filter:', typeFilter);

        // Debug: kiểm tra các phần tử lọc
        console.log('Filter status element:', filterStatus);
        console.log('Filter type element:', filterType);
        if (filterStatus) console.log('Filter status selected index:', filterStatus.selectedIndex);
        if (filterType) console.log('Filter type selected index:', filterType.selectedIndex);

        // Xử lý đặc biệt cho trường hợp chỉ hiển thị danh mục con
        if (typeFilter === 'child') {
            // Ẩn tất cả danh mục cha
            var parentRows = document.querySelectorAll('.parent-row');
            parentRows.forEach(function(row) {
                row.style.display = 'none';
            });

            // Hiển thị danh mục con phù hợp với điều kiện tìm kiếm và trạng thái
            var childRows = document.querySelectorAll('.child-row');
            childRows.forEach(function(row) {
                try {
                    var cells = row.querySelectorAll('td');
                    if (cells.length >= 7) {
                        var childName = cells[1].textContent.toLowerCase();
                        var childStatusCell = cells[6];
                        var childSuccessBadge = childStatusCell ? childStatusCell.querySelector('.badge-success') : null;
                        var childIsActive = !!childSuccessBadge;

                        var childMatchesSearch = childName.includes(searchText);
                        var childMatchesStatus = (statusFilter === 'all') ||
                                                (statusFilter === 'active' && childIsActive) ||
                                                (statusFilter === 'inactive' && !childIsActive);

                        row.style.display = (childMatchesSearch && childMatchesStatus) ? 'table-row' : 'none';
                    }
                } catch (e) {
                    console.error('Error processing child row for child filter:', e);
                }
            });

            // Thoát khỏi hàm vì đã xử lý xong
            return;
        }

        // Lọc danh mục cha
        var parentRows = document.querySelectorAll('.parent-row');
        console.log('Parent rows found:', parentRows.length);

        parentRows.forEach(function(row) {
            try {
                // Debug: hiển thị nội dung của hàng
                console.log('Parent row HTML:', row.innerHTML);

                // Lấy tất cả các ô trong hàng
                var cells = row.querySelectorAll('td');
                console.log('Cells found:', cells.length);

                // Lấy tên danh mục từ ô thứ 2
                var categoryNameCell = cells[1]; // index 1 là cột thứ 2
                var categoryName = categoryNameCell ? categoryNameCell.textContent.toLowerCase() : '';
                console.log('Category name:', categoryName);

                // Lấy trạng thái từ ô thứ 7 (index 6)
                var statusCell = cells[6]; // index 6 là cột thứ 7
                var categoryStatus = statusCell ? statusCell.textContent.toLowerCase() : '';
                console.log('Category status:', categoryStatus);

                // Kiểm tra trạng thái hoạt động dựa trên badge
                var successBadge = statusCell ? statusCell.querySelector('.badge-success') : null;
                var isActive = !!successBadge;
                console.log('Is active:', isActive, 'Success badge found:', !!successBadge);

                var matchesSearch = categoryName.includes(searchText);
                var matchesStatus = (statusFilter === 'all') ||
                                   (statusFilter === 'active' && isActive) ||
                                   (statusFilter === 'inactive' && !isActive);
                var matchesType = (typeFilter === 'all') || (typeFilter === 'parent');

                console.log('Matches search:', matchesSearch);
                console.log('Matches status:', matchesStatus, '(filter:', statusFilter, ')');
                console.log('Matches type:', matchesType, '(filter:', typeFilter, ')');

                // Debug: hiển thị chi tiết về điều kiện lọc loại
                console.log('Type filter === all:', typeFilter === 'all');
                console.log('Type filter === parent:', typeFilter === 'parent');
                console.log('Type filter === child:', typeFilter === 'child');

                var shouldShow = matchesSearch && matchesStatus && matchesType;
                console.log('Should show:', shouldShow);

                row.style.display = shouldShow ? 'table-row' : 'none';

                // Nếu danh mục cha ẩn hoặc chỉ hiển thị danh mục con, ẩn/hiển thị danh mục con tương ứng
                var parentId = row.id.split('-')[1];
                var childRows = document.querySelectorAll('.child-of-' + parentId);

                if (!shouldShow) {
                    // Nếu danh mục cha ẩn, ẩn tất cả danh mục con
                    childRows.forEach(function(childRow) {
                        childRow.style.display = 'none';
                    });
                } else if (typeFilter === 'child') {
                    // Nếu chỉ hiển thị danh mục con, ẩn danh mục cha
                    row.style.display = 'none';

                    // Nhưng vẫn hiển thị danh mục con (nếu phù hợp với các điều kiện lọc khác)
                    childRows.forEach(function(childRow) {
                        // Kiểm tra xem danh mục con có phù hợp với điều kiện tìm kiếm và trạng thái không
                        var cells = childRow.querySelectorAll('td');
                        if (cells.length >= 7) {
                            var childName = cells[1].textContent.toLowerCase();
                            var childStatusCell = cells[6];
                            var childSuccessBadge = childStatusCell ? childStatusCell.querySelector('.badge-success') : null;
                            var childIsActive = !!childSuccessBadge;

                            console.log('Child row processing for filter=child:', childName);
                            console.log('Child is active:', childIsActive);

                            var childMatchesSearch = childName.includes(searchText);
                            var childMatchesStatus = (statusFilter === 'all') ||
                                                    (statusFilter === 'active' && childIsActive) ||
                                                    (statusFilter === 'inactive' && !childIsActive);

                            console.log('Child matches search:', childMatchesSearch);
                            console.log('Child matches status:', childMatchesStatus);

                            if (childMatchesSearch && childMatchesStatus) {
                                childRow.style.display = 'table-row';
                                console.log('Showing child row:', childName);
                            } else {
                                childRow.style.display = 'none';
                                console.log('Hiding child row:', childName);
                            }
                        }
                    });
                }
            } catch (e) {
                console.error('Error processing parent row:', e);
            }
        });

        // Xử lý danh mục con
        // Nếu chỉ hiển thị danh mục con, cần xử lý đặc biệt ở đây
        if (typeFilter === 'child') {
            // Lấy tất cả danh mục con
            var allChildRows = document.querySelectorAll('.child-row');
            console.log('Processing all child rows for child filter, found:', allChildRows.length);

            // Hiển thị tất cả danh mục con phù hợp với điều kiện tìm kiếm và trạng thái
            allChildRows.forEach(function(childRow) {
                try {
                    var cells = childRow.querySelectorAll('td');
                    if (cells.length >= 7) {
                        var childName = cells[1].textContent.toLowerCase();
                        var childStatusCell = cells[6];
                        var childSuccessBadge = childStatusCell ? childStatusCell.querySelector('.badge-success') : null;
                        var childIsActive = !!childSuccessBadge;

                        console.log('Direct child processing:', childName);
                        console.log('Child is active:', childIsActive);

                        var childMatchesSearch = childName.includes(searchText);
                        var childMatchesStatus = (statusFilter === 'all') ||
                                                (statusFilter === 'active' && childIsActive) ||
                                                (statusFilter === 'inactive' && !childIsActive);

                        console.log('Child matches search:', childMatchesSearch);
                        console.log('Child matches status:', childMatchesStatus);

                        if (childMatchesSearch && childMatchesStatus) {
                            childRow.style.display = 'table-row';
                            console.log('SHOWING child row directly:', childName);
                        } else {
                            childRow.style.display = 'none';
                            console.log('HIDING child row directly:', childName);
                        }
                    }
                } catch (e) {
                    console.error('Error processing child row directly:', e);
                }
            });
        } else {
            // Lọc danh mục con chỉ khi hiển thị tất cả hoặc chỉ danh mục cha
            var childRows = document.querySelectorAll('.child-row');
            console.log('Child rows found:', childRows.length);

            childRows.forEach(function(row) {
                try {
                    // Debug: hiển thị nội dung của hàng
                    console.log('Child row HTML:', row.innerHTML);

                    var classNames = row.className.split(' ');
                    var childOfClass = classNames.find(function(className) {
                        return className.startsWith('child-of-');
                    });

                    if (childOfClass) {
                        var parentId = childOfClass.replace('child-of-', '');
                        console.log('Parent ID:', parentId);

                        var parentRow = document.getElementById('parent-' + parentId);
                        console.log('Parent row found:', !!parentRow);

                        if (parentRow) {
                            var parentVisible = parentRow.style.display !== 'none';
                            console.log('Parent visible:', parentVisible);

                            // Hiển thị danh mục con nếu danh mục cha đang hiển thị và bộ lọc là 'all'
                            if (parentVisible && typeFilter === 'all') {
                                // Lấy tất cả các ô trong hàng
                                var cells = row.querySelectorAll('td');
                                console.log('Child cells found:', cells.length);

                                // Lấy tên danh mục từ ô thứ 2
                                var categoryNameCell = cells[1]; // index 1 là cột thứ 2
                                var categoryName = categoryNameCell ? categoryNameCell.textContent.toLowerCase() : '';
                                console.log('Child category name:', categoryName);

                                // Lấy trạng thái từ ô thứ 7 (index 6)
                                var statusCell = cells[6]; // index 6 là cột thứ 7
                                var categoryStatus = statusCell ? statusCell.textContent.toLowerCase() : '';
                                console.log('Child category status:', categoryStatus);

                                // Kiểm tra trạng thái hoạt động dựa trên badge
                                var successBadge = statusCell ? statusCell.querySelector('.badge-success') : null;
                                var isActive = !!successBadge;
                                console.log('Child is active:', isActive, 'Success badge found:', !!successBadge);

                                var matchesSearch = categoryName.includes(searchText);
                                var matchesStatus = (statusFilter === 'all') ||
                                                   (statusFilter === 'active' && isActive) ||
                                                   (statusFilter === 'inactive' && !isActive);

                                console.log('Child matches search:', matchesSearch);
                                console.log('Child matches status:', matchesStatus);

                                var shouldShow = matchesSearch && matchesStatus;
                                console.log('Child should show:', shouldShow);

                                row.style.display = shouldShow ? 'table-row' : 'none';
                            } else if (typeFilter === 'parent') {
                                // Nếu chỉ hiển thị danh mục cha, ẩn tất cả danh mục con
                                row.style.display = 'none';
                            }
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        console.warn('No child-of class found for row:', row);
                    }
                } catch (e) {
                    console.error('Error processing child row:', e, row);
                }
            });
        }
    }

    // Đăng ký sự kiện
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
        console.log('Search input event registered');
    }
    if (filterStatus) {
        filterStatus.addEventListener('change', filterTable);
        console.log('Filter status event registered');
    }
    if (filterType) {
        filterType.addEventListener('change', filterTable);
        console.log('Filter type event registered');
    }

    // Đặt giá trị mặc định cho các bộ lọc
    if (filterStatus) filterStatus.value = 'all';
    if (filterType) filterType.value = 'all';

    // Đặt trạng thái ban đầu cho các hàng con
    var initialChildRows = document.querySelectorAll('.child-row');
    initialChildRows.forEach(function(row) {
        // Mặc định hiển thị tất cả hàng con
        row.style.display = 'table-row';
    });

    // Gọi filterTable một lần khi trang tải để áp dụng bộ lọc mặc định
    setTimeout(function() {
        console.log('Running initial filter');
        filterTable();
    }, 500);
});
</script>
