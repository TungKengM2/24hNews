@extends('author.layouts.master')

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
                                    <li class="breadcrumb-item"><a href="{{ route('author.dashboard') }}"><i
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
                                <a href="{{ route('author.dashboard') }}" class="btn btn-default">
                                    <i class="fa fa-arrow-left me-1"></i> Quay Lại
                                </a>
                                @if (isset($isBanned) && $isBanned)
                                    <button type="button" class="btn btn-primary ms-2 disabled" id="addNewArticleBtn">
                                        <i class="si-plus si me-1"></i> Thêm Bài Viết Mới
                                    </button>
                                @else
                                    <a href="{{ route('author.articles.create') }}" class="btn btn-primary ms-2">
                                        <i class="si-plus si me-1"></i> Thêm Bài Viết Mới
                                    </a>
                                @endif
                            </div>
                            <div class="d-flex">
                                <div class="input-group me-2">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}">
                                    <input type="text" id="categoryFilter" class="form-control"
                                        placeholder="Tìm kiếm danh mục..." style="max-width: 200px;">
                                    <button type="button" class="btn btn-primary" id="searchButton">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>


                        </div>

                        <div class="box-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <form method="GET" action="{{ route('author.articles.index') }}" id="filter-form">
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

                            <div class="card-body">
                                @if($isBanned)
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Tài khoản của bạn đã bị cấm đăng bài. Thời gian cấm kết thúc vào: {{ $banEndTime }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0" style="width:100%">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th class="text-center" width="5%">ID</th>
                                                <th class="text-center" width="15%">Tiêu Đề</th>
                                                <th class="text-center" width="10%">Hình Ảnh</th>
                                                <th class="text-center" width="10%">Danh Mục</th>
                                                <th class="text-center" width="10%">Trạng Thái</th>
                                                <th class="text-center" width="10%">Lượt Xem</th>
                                                <th class="text-center" width="10%">Tags</th>
                                                <th class="text-center" width="10%">Thời Gian Tạo</th>
                                                <th class="text-center" width="20%">Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="articles-table-body">
                                            @forelse ($articles as $article)
                                                <tr>
                                                    <td class="text-center">{{ $article->article_id }}</td>
                                                    <td class="text-center">
                                                        <strong>{{ $article->title }}</strong>
                                                        <div class="small text-muted">{{ Str::limit($article->slug, 30) }}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh" class="img-thumbnail" width="80" height="80">
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($article->category)
                                                            @if (!$article->category->is_active)
                                                                <span class="text-warning">{{ $article->category->name }} <i class="fa fa-exclamation-triangle"></i></span>
                                                            @else
                                                                <span class="badge bg-info">{{ $article->category->name }}</span>
                                                            @endif

                                                            @if ($article->subcategory)
                                                                <div class="mt-1">
                                                                    @if (!$article->subcategory->is_active)
                                                                        <span class="text-warning">{{ $article->subcategory->name }} <i class="fa fa-exclamation-triangle"></i></span>
                                                                    @else
                                                                        <span class="badge bg-secondary">{{ $article->subcategory->name }}</span>
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
                                                                <span class="badge bg-info">Đã Lưu Trữ</span>
                                                            @break

                                                            @case('rejected')
                                                                <span class="badge bg-danger">Từ Chối</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td class="text-center">{{ number_format($article->views) }}</td>
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
                                                    <td class="text-center">{{ $article->created_at->format('d/m/Y H:i') }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-wrap gap-1 mb-2">
                                                            <a href="{{ route('author.articles.show', $article) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                                <i class="si-eye si"></i>
                                                            </a>

                                                            @if ($article->status !== 'published')
                                                                <a href="{{ route('author.articles.edit', $article) }}" class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                                    <i class="si-pencil si"></i>
                                                                </a>
                                                            @else
                                                                <button type="button" class="btn btn-secondary btn-sm" style="display: none" title="Không thể chỉnh sửa bài viết đã xuất bản">
                                                                    <i class="si-pencil si"></i>
                                                                </button>
                                                            @endif

                                                            @if (in_array($article->status, ['published', 'archived']))
                                                                <form action="{{ route('author.articles.toggle-visibility', $article) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    @if (request()->has('page'))
                                                                        <input type="hidden" name="page" value="{{ request('page') }}">
                                                                    @endif
                                                                    @if (request()->has('filter'))
                                                                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                                                                    @endif
                                                                    @if (request()->has('search'))
                                                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                                                    @endif
                                                                    <button class="btn btn-secondary btn-sm toggle-visibility-btn" title="{{ $article->status === 'published' ? 'Ẩn bài viết' : 'Hiện bài viết' }}" data-action="{{ $article->status === 'published' ? 'ẩn' : 'hiện' }}">
                                                                        <i class="fa {{ $article->status === 'published' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            @if ($article->status === 'rejected')
                                                                <form action="{{ route('author.articles.request-review', $article) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    @if (request()->has('page'))
                                                                        <input type="hidden" name="page" value="{{ request('page') }}">
                                                                    @endif
                                                                    @if (request()->has('filter'))
                                                                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                                                                    @endif
                                                                    @if (request()->has('search'))
                                                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                                                    @endif
                                                                    <button class="btn btn-primary btn-sm request-review-btn" title="Xin duyệt lại" data-article-id="{{ $article->article_id }}">
                                                                        <i class="fa fa-paper-plane"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            <form action="{{ route('author.articles.destroy', $article) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm delete-article-btn" title="Xóa bài viết" data-article-id="{{ $article->article_id }}" data-article-title="{{ $article->title }}">
                                                                    <i class="si-trash si"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Không có bài viết nào</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            const searchButton = document.getElementById('searchButton');

            // Cache cho kết quả tìm kiếm
            const searchCache = new Map();
            let currentRequest = null;

            function showLoading() {
                articlesTableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center">
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

                const cacheKey = params.toString();

                // Kiểm tra cache
                if (searchCache.has(cacheKey)) {
                    updateTable(searchCache.get(cacheKey));
                    return;
                }

                // Hiển thị loading
                showLoading();

                // Hủy request đang chạy nếu có
                if (currentRequest) {
                    currentRequest.abort();
                }

                // Tạo AbortController cho request mới
                const controller = new AbortController();
                currentRequest = controller;

                fetch(`{{ route('author.articles.index') }}?${cacheKey}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    signal: controller.signal
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Lưu vào cache
                    searchCache.set(cacheKey, data);
                    updateTable(data);
                    currentRequest = null;
                })
                .catch(error => {
                    if (error.name === 'AbortError') {
                        return;
                    }
                    console.error('Error:', error);
                    articlesTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.</td></tr>';
                    currentRequest = null;
                });
            }

            // Debounce function để tránh gọi API quá nhiều
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

            // Sử dụng debounce với thời gian 300ms
            const debouncedFetchArticles = debounce(fetchArticles, 300);

            // Thêm event listener cho các bộ lọc
            [articleFilter, categoryFilter, startDate, endDate].forEach(element => {
                element.addEventListener('change', debouncedFetchArticles);
            });

            // Thêm event listener cho nút tìm kiếm
            searchButton.addEventListener('click', fetchArticles);

            // Thêm event listener cho các ô tìm kiếm với real-time search
            searchInput.addEventListener('input', debouncedFetchArticles);
            categorySearchInput.addEventListener('input', debouncedFetchArticles);

            // Xử lý nút reset
            resetButton.addEventListener('click', function() {
                filterForm.reset();
                searchInput.value = '';
                categorySearchInput.value = '';
                searchCache.clear(); // Xóa cache khi reset
                fetchArticles();
            });

            // Xử lý phân trang
            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.pagination a');
                if (!paginationLink) return;

                e.preventDefault();
                const url = paginationLink.href;
                const cacheKey = new URL(url).search.substring(1); // Bỏ dấu ? ở đầu

                if (searchCache.has(cacheKey)) {
                    updateTable(searchCache.get(cacheKey));
                    return;
                }

                // Hiển thị loading khi chuyển trang
                showLoading();

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    searchCache.set(cacheKey, data);
                    updateTable(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    articlesTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger">Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.</td></tr>';
                });
            });

            // Xử lý các nút thao tác trong bảng
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

            // Khởi tạo event listeners khi trang được tải
            initializeTableEventListeners();

            // Tự động tìm kiếm khi trang được tải (nếu có tham số tìm kiếm)
            if (searchInput.value.trim() || categorySearchInput.value.trim()) {
                fetchArticles();
            }
        });
    </script>
@endsection
