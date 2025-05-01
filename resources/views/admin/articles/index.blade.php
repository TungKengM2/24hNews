@extends('admin.layouts.master')

@section('title')
    Danh Sách Bài Viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Danh Sách Bài Viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Viết</li>
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
                        <div class="box-header with-border d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-default">
                                    <i class="fa fa-arrow-left me-1"></i> Quay Lại
                                </a>
                                <a href="{{ route('articles.create') }}" class="btn btn-primary ms-2">
                                    <i class="si-plus si me-1"></i> Thêm Bài Viết Mới
                                </a>
                            </div>

                            @if (session('success'))
                                <div id="success-alert"
                                    class="alert alert-success alert-dismissible fade show custom-alert m-0">
                                    <div class="d-flex align-items-center">
                                        <div class="alert-icon me-2">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="alert-message">
                                            <p class="mb-0"><strong>Thành công!</strong> {{ session('success') }}</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="d-flex">
                                <div class="input-group me-2">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}">
                                    <input type="text" id="categoryFilter" class="form-control"
                                        placeholder="Tìm kiếm danh mục..." style="max-width: 200px;">
                                    <input type="text" id="authorFilter" class="form-control"
                                        placeholder="Tìm kiếm tác giả..." style="max-width: 200px;">
                                    <button type="button" class="btn btn-primary" id="searchButton">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>


                        </div>

                        <style>
                            .custom-alert {
                                position: relative;
                                border-left: 4px solid #28a745;
                                background-color: #fff;
                                color: #333;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                padding: 8px 15px;
                                border-radius: 5px;
                                max-width: 400px;
                                animation: fadeInAlert 0.3s forwards;
                                z-index: 100;
                            }

                            .alert-icon {
                                color: #28a745;
                            }

                            @keyframes fadeInAlert {
                                0% {
                                    opacity: 0;
                                }

                                100% {
                                    opacity: 1;
                                }
                            }

                            @media (max-width: 992px) {
                                .box-header {
                                    flex-direction: column;
                                    gap: 10px;
                                }

                                .custom-alert {
                                    max-width: 100%;
                                    width: 100%;
                                    order: 3;
                                }
                            }
                        </style>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                console.log('Hiển thị thông báo thành công: {{ session('success') }}');
                                setTimeout(function() {
                                    var alertElement = document.getElementById('success-alert');
                                    if (alertElement) {
                                        alertElement.style.opacity = '0';
                                        alertElement.style.transition = 'opacity 0.5s';
                                        setTimeout(function() {
                                            alertElement.style.display = 'none';
                                        }, 500);
                                    }
                                }, 5000);
                            });
                        </script>

                        <div class="box-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <form method="GET" action="{{ route('articles.index') }}" id="filter-form">
                                        <div class="d-flex align-items-center">
                                            <label for="article_filter" class="me-2 fw-bold">Lọc bài viết:</label>
                                            <select name="article_filter" class="form-select w-auto me-3" id="article_filter">
                                                <option value="all" {{ request('article_filter') == 'all' ? 'selected' : '' }}>
                                                    Tất cả bài viết</option>
                                                <option value="draft" {{ request('article_filter') == 'draft' ? 'selected' : '' }}>
                                                    Bản nháp</option>
                                                <option value="pending" {{ request('article_filter') == 'pending' ? 'selected' : '' }}>
                                                    Chờ duyệt</option>
                                                <option value="published" {{ request('article_filter') == 'published' ? 'selected' : '' }}>
                                                    Đã đăng</option>
                                                <option value="rejected" {{ request('article_filter') == 'rejected' ? 'selected' : '' }}>
                                                    Từ chối</option>
                                                <option value="archived" {{ request('article_filter') == 'archived' ? 'selected' : '' }}>
                                                    Đã lưu trữ</option>
                                            </select>

                                            <label for="category_filter" class="me-2 fw-bold">Lọc danh mục:</label>
                                            <select name="category_filter" class="form-select w-auto" id="category_filter">
                                                <option value="all" {{ request('category_filter') == 'all' ? 'selected' : '' }}>
                                                    Tất cả danh mục</option>
                                                <option value="active" {{ request('category_filter') == 'active' ? 'selected' : '' }}>
                                                    Danh mục hoạt động</option>
                                                <option value="inactive" {{ request('category_filter') == 'inactive' ? 'selected' : '' }}>
                                                    Danh mục bị vô hiệu hóa</option>
                                                <option value="no_category" {{ request('category_filter') == 'no_category' ? 'selected' : '' }}>
                                                    Chưa có danh mục</option>
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center mt-2">
                                            <label for="start_date" class="me-2 fw-bold">Từ ngày:</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control w-auto me-2"
                                                value="{{ request('start_date') }}">
                                            <label for="end_date" class="me-2 fw-bold">Đến ngày:</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control w-auto me-2"
                                                value="{{ request('end_date') }}">
                                            <button type="button" class="btn btn-secondary" id="reset-button">Reset</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="badge bg-info">Tổng số: {{ $articles->total() }} bài viết</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-center" width="5%">ID</th>
                                            <th class="text-center" width="15%">Tiêu Đề</th>
                                            <th class="text-center" width="10%">Hình Ảnh</th>
                                            <th class="text-center" width="10%">Danh Mục</th>
                                            <th class="text-center" width="10%">Trạng Thái</th>
                                            <th class="text-center" width="10%">Tác Giả</th>
                                            <th class="text-center" width="10%">Lượt Xem</th>
                                            <th class="text-center" width="10%">Tags</th>
                                            <th class="text-center" width="10%">Thời Gian Tạo</th>
                                            {{-- <th width="10%">Nội Dung Nhạy Cảm</th> --}}
                                            <th class="text-center" width="20%">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="articles-table-body">
                                        @forelse ($articles as $article)
                                            <tr>
                                                <td class="text-center">{{ $article->article_id }}</td>
                                                <td class="text-center">
                                                    <strong>{{ $article->title }}</strong>
                                                    {{-- <div class="small text-muted">{{ Str::limit($article->slug, 30) }}
                                                    </div> --}}
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                        alt="Hình ảnh" class="img-thumbnail" width="80" height="80">
                                                </td>
                                                <td class="text-center">
                                                    @if ($article->category)
                                                        @if (!$article->category->is_active)
                                                            <span class="text-warning">{{ $article->category->name }} <i
                                                                    class="fa fa-exclamation-triangle"></i></span>
                                                        @else
                                                            <span
                                                                class="badge bg-info">{{ $article->category->name }}</span>
                                                        @endif

                                                        @if ($article->subcategory)
                                                            <div class="mt-1">

                                                                @if (!$article->subcategory->is_active)
                                                                    <span
                                                                        class="text-warning">{{ $article->subcategory->name }}
                                                                        <i class="fa fa-exclamation-triangle"></i></span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-secondary">{{ $article->subcategory->name }}</span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @else
                                                        <span class="text-danger">Không có danh mục</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @switch($article->status)
                                                        @case('draft')
                                                            <span class="badge bg-secondary">Bản Nháp</span>
                                                        @break

                                                        @case('pending')
                                                            <span class="badge bg-warning">Chờ Duyệt</span>
                                                        @break

                                                        @case('published')
                                                            <span class="badge bg-success">Đã Đăng</span>
                                                        @break

                                                        @case('archived')
                                                            <span class="badge bg-danger">Đã Lưu Trữ</span>
                                                        @break
                                                        @case('rejected')
                                                            <span class="badge bg-danger">Từ Chối</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="text-center">
                                                    {{ $article->author->username ?? 'Chưa xác định' }}</td>
                                                <td class="text-center">{{ number_format($article->views) }}</td>
                                                {{-- <td class="text-center">
                                                    @if ($article->contains_sensitive_content)
                                                        <span class="badge bg-danger">Có</span>
                                                    @else
                                                        <span class="badge bg-success">Không</span>
                                                    @endif
                                                </td> --}}
                                                <td class="text-center">
                                                    <div>
                                                        @if ($article->tags->isNotEmpty())
                                                            @foreach ($article->tags as $tag)
                                                                <span class="badge bg-primary">{{ $tag->name }}</span>
                                                            @endforeach
                                                        @else
                                                            <small class="text-muted">Không có thẻ</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $article->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('articles.show', $article) }}"
                                                        class="btn btn-info btn-sm" title="Xem chi tiết"><i
                                                            class="si-eye si"></i></a>
                                                    <a href="{{ route('articles.moderation-history', $article) }}"
                                                        class="btn btn-secondary btn-sm" title="Lịch sử kiểm duyệt">
                                                        <i class="fas fa-history"></i>
                                                    </a>
                                                    @if (auth()->id() === $article->author_id)
                                                        <a href="{{ route('articles.edit', $article) }}"
                                                            class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                            <i class="si-pencil si"></i>
                                                        </a>
                                                    @endif

                                                    @if (in_array($article->status, ['published', 'archived']))
                                                        <form action="{{ route('articles.toggle-visibility', $article) }}" method="POST" class="d-inline toggle-visibility-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="page" value="{{ request('page') }}">
                                                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                                            <button type="button" class="btn btn-secondary btn-sm toggle-visibility-btn"
                                                                title="{{ $article->status === 'published' ? 'Ẩn bài viết' : 'Hiện bài viết' }}"
                                                                data-id="{{ $article->article_id }}"
                                                                data-action="{{ $article->status === 'published' ? 'ẩn' : 'hiện' }}">
                                                                <i class="fa {{ $article->status === 'published' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('articles.destroy', $article) }}"
                                                        method="POST" class="d-inline delete-article-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm delete-article-btn"
                                                            title="Xóa" data-id="{{ $article->article_id }}" data-title="{{ $article->title }}">
                                                            <i class="si-trash si"></i>
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Không có bài viết nào</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end mt-4" id="pagination-links">
                                        {{ $articles->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Hiển thị thông báo thành công từ session
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: '{{ session('success') }}',
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                @endif

                // Hiển thị thông báo lỗi từ session
                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'Đóng'
                    });
                @endif

                // Hiển thị thông báo cảnh báo từ session
                @if (session('warning'))
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cảnh báo!',
                        text: '{{ session('warning') }}',
                        confirmButtonText: 'Đóng'
                    });
                @endif

                // Hiển thị thông báo thông tin từ session
                @if (session('info'))
                    Swal.fire({
                        icon: 'info',
                        title: 'Thông tin!',
                        text: '{{ session('info') }}',
                        confirmButtonText: 'Đóng'
                    });
                @endif

                // Xử lý nút xóa bài viết với SweetAlert2
                document.querySelectorAll('.delete-article-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const articleId = this.getAttribute('data-id');
                        const articleTitle = this.getAttribute('data-title');
                        const form = this.closest('form');

                        Swal.fire({
                            title: 'Xác nhận xóa?',
                            html: `Bạn có chắc chắn muốn xóa bài viết <strong>${articleTitle}</strong> không?<br>Hành động này không thể hoàn tác!`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                // Xử lý nút ẩn/hiện bài viết với SweetAlert2
                document.querySelectorAll('.toggle-visibility-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const action = this.getAttribute('data-action');
                        const form = this.closest('form');

                        Swal.fire({
                            title: `${action.charAt(0).toUpperCase() + action.slice(1)} bài viết?`,
                            text: `Bạn có chắc chắn muốn ${action} bài viết này không?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Xác nhận',
                            cancelButtonText: 'Hủy'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                // Xử lý form lọc với AJAX
                const filterForm = document.getElementById('filter-form');
                const articlesTableBody = document.getElementById('articles-table-body');
                const paginationLinks = document.getElementById('pagination-links');
                const articleFilter = document.getElementById('article_filter');
                const categoryFilter = document.getElementById('category_filter');
                const startDate = document.getElementById('start_date');
                const endDate = document.getElementById('end_date');
                const resetButton = document.getElementById('reset-button');
                const searchInput = document.getElementById('searchInput');
                const categorySearchInput = document.getElementById('categoryFilter');
                const authorSearchInput = document.getElementById('authorFilter');
                const searchButton = document.getElementById('searchButton');

                // Cache cho kết quả tìm kiếm
                const searchCache = new Map();
                let currentRequest = null;

                function showLoading() {
                    articlesTableBody.innerHTML = `
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    `;
                }

                function updateTable(data) {
                    if (!data || !data.html) {
                        console.error('Invalid response data');
                        return;
                    }

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data.html, 'text/html');

                    const newTableBody = doc.querySelector('#articles-table-body');
                    const newPagination = doc.querySelector('#pagination-links');

                    if (newTableBody) {
                        articlesTableBody.innerHTML = newTableBody.innerHTML;
                    }
                    if (newPagination) {
                        paginationLinks.innerHTML = newPagination.innerHTML;
                    }

                    initializeTableEventListeners();
                }

                function fetchArticles() {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);

                    // Thêm các tham số tìm kiếm vào URL
                    const searchTerm = searchInput.value.trim();
                    const categoryTerm = categorySearchInput.value.trim();
                    const authorTerm = authorSearchInput.value.trim();

                    if (searchTerm) {
                        params.set('search', searchTerm);
                    } else {
                        params.delete('search');
                    }

                    if (categoryTerm) {
                        params.set('category', categoryTerm);
                    } else {
                        params.delete('category');
                    }

                    if (authorTerm) {
                        params.set('author', authorTerm);
                    } else {
                        params.delete('author');
                    }

                    const cacheKey = params.toString();

                    // Kiểm tra cache
                    if (searchCache.has(cacheKey)) {
                        updateTable(searchCache.get(cacheKey));
                        return;
                    }

                    // Hiển thị loading
                    showLoading();

                    fetch(`{{ route('articles.index') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.html) {
                            searchCache.set(cacheKey, data);
                            updateTable(data);
                        } else {
                            throw new Error('Invalid response format');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (!searchCache.has(cacheKey)) {
                            articlesTableBody.innerHTML = '<tr><td colspan="10" class="text-center text-danger">Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.</td></tr>';
                        }
                    });
                }

                // Debounce function với thời gian ngắn hơn
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                // Sử dụng debounce với thời gian ngắn hơn (300ms)
                const debouncedFetchArticles = debounce(fetchArticles, 300);

                // Xử lý các bộ lọc chính
                [articleFilter, categoryFilter, startDate, endDate].forEach(element => {
                    element.addEventListener('change', function() {
                        showLoading();
                        debouncedFetchArticles();
                    });
                });

                // Xử lý tìm kiếm nội dung
                searchInput.addEventListener('input', debouncedFetchArticles);
                categorySearchInput.addEventListener('input', debouncedFetchArticles);
                authorSearchInput.addEventListener('input', debouncedFetchArticles);

                // Xử lý nút tìm kiếm
                searchButton.addEventListener('click', function() {
                    showLoading();
                    fetchArticles();
                });

                // Xử lý nút reset
                resetButton.addEventListener('click', function() {
                    filterForm.reset();
                    searchInput.value = '';
                    categorySearchInput.value = '';
                    authorSearchInput.value = '';
                    searchCache.clear(); // Xóa cache khi reset
                    showLoading();
                    fetchArticles();
                });

                // Tối ưu sự kiện phân trang
                document.addEventListener('click', function(e) {
                    const paginationLink = e.target.closest('.pagination a');
                    if (!paginationLink) return;

                    e.preventDefault();
                    const url = paginationLink.href;
                    const cacheKey = new URL(url).search.substring(1); // Remove the leading '?'

                    if (searchCache.has(cacheKey)) {
                        updateTable(searchCache.get(cacheKey));
                        return;
                    }

                    // Hiển thị loading khi chuyển trang
                    showLoading();

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.html) {
                            searchCache.set(cacheKey, data);
                            updateTable(data);
                        } else {
                            throw new Error('Invalid response format');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (!searchCache.has(cacheKey)) {
                            articlesTableBody.innerHTML = '<tr><td colspan="10" class="text-center text-danger">Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.</td></tr>';
                        }
                    });
                });

                // Tối ưu event listeners cho bảng
                function initializeTableEventListeners() {
                    const handleAction = (button, action, message) => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const form = this.closest('form');
                            const articleTitle = this.dataset.articleTitle;

                            Swal.fire({
                                title: 'Xác nhận',
                                text: message,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Đồng ý',
                                cancelButtonText: 'Hủy'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Hiển thị loading khi thực hiện hành động
                                    showLoading();

                                    fetch(form.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        body: new FormData(form)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Thành công!',
                                                text: data.message,
                                                confirmButtonText: 'Đóng'
                                            }).then(() => {
                                                searchCache.clear(); // Xóa cache sau khi thay đổi
                                                fetchArticles();
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi!',
                                            text: 'Đã xảy ra lỗi khi thực hiện thao tác. Vui lòng thử lại.',
                                            confirmButtonText: 'Đóng'
                                        });
                                    });
                                }
                            });
                        });
                    };

                    document.querySelectorAll('.toggle-visibility-btn').forEach(button => {
                        handleAction(button, 'toggle', `Bạn có chắc chắn muốn ${button.dataset.action} bài viết này?`);
                    });

                    document.querySelectorAll('.delete-article-btn').forEach(button => {
                        handleAction(button, 'delete', `Bạn có chắc chắn muốn xóa bài viết "${button.dataset.articleTitle}"?`);
                    });

                    document.querySelectorAll('.request-review-btn').forEach(button => {
                        handleAction(button, 'review', 'Bạn có chắc chắn muốn gửi yêu cầu duyệt lại bài viết này?');
                    });
                }

                initializeTableEventListeners();

                // Tự động tìm kiếm khi trang được tải (nếu có tham số tìm kiếm)
                if (searchInput.value.trim() || categorySearchInput.value.trim() || authorSearchInput.value.trim()) {
                    fetchArticles();
                }
            });
        </script>
    @endsection
