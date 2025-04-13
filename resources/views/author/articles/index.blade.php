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
                                @if (auth()->user()->violation_count > 5)
                                    <button type="button" class="btn btn-primary ms-2 disabled" id="addNewArticleBtn">
                                        <i class="si-plus si me-1"></i> Thêm Bài Viết Mới
                                    </button>
                                @else
                                    <a href="{{ route('author.articles.create') }}" class="btn btn-primary ms-2">
                                        <i class="si-plus si me-1"></i> Thêm Bài Viết Mới
                                    </a>
                                @endif
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
                                <form method="GET" action="{{ route('author.articles.index') }}" class="me-2">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
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

                        {{-- Script moved to @section('scripts') --}}

                        <div class="box-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <form method="GET" action="{{ route('author.articles.index') }}" id="filter-form">
                                        <div class="d-flex align-items-center">
                                            <label for="filter" class="me-2 fw-bold">Lọc bài viết:</label>
                                            <select name="filter" class="form-select w-auto"
                                                onchange="document.getElementById('filter-form').submit()">
                                                <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>
                                                    Tất cả bài viết</option>
                                                <option value="active"
                                                    {{ request('filter') == 'active' ? 'selected' : '' }}>Bài viết có danh
                                                    mục hoạt động</option>
                                                <option value="inactive"
                                                    {{ request('filter') == 'inactive' ? 'selected' : '' }}>Bài viết có danh
                                                    mục bị vô hiệu hóa</option>
                                                {{-- <option value="no_category"
                                                    {{ request('filter') == 'no_category' ? 'selected' : '' }}>Bài viết
                                                    không có danh mục</option> --}}
                                                <option value="archived"
                                                    {{ request('filter') == 'archived' ? 'selected' : '' }}>Bài viết
                                                    đã ẩn</option>
                                            </select>
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
                                            <th class="text-center" width="10%">Lượt Xem</th>
                                            {{-- <th width="10%">Nội Dung Nhạy Cảm</th> --}}
                                            <th class="text-center" width="10%">Tags</th>
                                            <th class="text-center" width="20%">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($articles as $article)
                                            <tr>
                                                <td class="text-center">{{ $article->article_id }}</td>
                                                <td class="text-center">
                                                    <strong>{{ $article->title }}</strong>
                                                    <div class="small text-muted">{{ Str::limit($article->slug, 30) }}
                                                    </div>
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
                                                            <span class="badge bg-info">Đã Lưu Trữ</span>
                                                        @break

                                                        @case('rejected')
                                                            <span class="badge bg-danger">Từ Chối</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="text-center">{{ number_format($article->views) }}</td>
                                                {{-- <td class="text-center">
                                                @if ($article->contains_sensitive_content)
                                                    <span class="badge bg-danger">Có</span>
                                                @else
                                                    <span class="badge bg-success">Không</span>
                                                @endif
                                            {{-- </td> --}}
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
                                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                                        <a href="{{ route('author.articles.show', $article) }}"
                                                            class="btn btn-info btn-sm" title="Xem chi tiết">
                                                            <i class="si-eye si"></i>
                                                        </a>

                                                        @if (in_array($article->status, ['pending', 'published']))
                                                            <button class="btn btn-warning btn-sm" title="Xin phép chỉnh sửa">
                                                                <i class="si-pencil si"></i> Xin phép chỉnh sửa
                                                            </button>
                                                        @else
                                                            <a href="{{ route('author.articles.edit', $article) }}"
                                                                class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                                <i class="si-pencil si"></i> Chỉnh sửa
                                                            </a>
                                                        @endif

                                                        @if (in_array($article->status, ['published', 'archived']))
                                                            <form
                                                                action="{{ route('author.articles.toggle-visibility', $article) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                @if (request()->has('page'))
                                                                    <input type="hidden" name="page"
                                                                        value="{{ request('page') }}">
                                                                @endif
                                                                @if (request()->has('filter'))
                                                                    <input type="hidden" name="filter"
                                                                        value="{{ request('filter') }}">
                                                                @endif
                                                                @if (request()->has('search'))
                                                                    <input type="hidden" name="search"
                                                                        value="{{ request('search') }}">
                                                                @endif
                                                                <button
                                                                    class="btn btn-secondary btn-sm toggle-visibility-btn"
                                                                    title="{{ $article->status === 'published' ? 'Ẩn bài viết' : 'Hiện bài viết' }}"
                                                                    data-action="{{ $article->status === 'published' ? 'ẩn' : 'hiện' }}">
                                                                    <i
                                                                        class="fa {{ $article->status === 'published' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if ($article->status === 'rejected')
                                                            <form
                                                                action="{{ route('author.articles.request-review', $article) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                @if (request()->has('page'))
                                                                    <input type="hidden" name="page"
                                                                        value="{{ request('page') }}">
                                                                @endif
                                                                @if (request()->has('filter'))
                                                                    <input type="hidden" name="filter"
                                                                        value="{{ request('filter') }}">
                                                                @endif
                                                                @if (request()->has('search'))
                                                                    <input type="hidden" name="search"
                                                                        value="{{ request('search') }}">
                                                                @endif
                                                                <button class="btn btn-primary btn-sm request-review-btn"
                                                                    title="Xin duyệt lại"
                                                                    data-article-id="{{ $article->article_id }}">
                                                                    <i class="fa fa-paper-plane"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <form action="{{ route('author.articles.destroy', $article) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm delete-article-btn"
                                                                title="Xóa bài viết"
                                                                data-article-id="{{ $article->article_id }}"
                                                                data-article-title="{{ $article->title }}">
                                                                <i class="si-trash si"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Không có bài viết nào</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end mt-4">
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
                // Hiển thị thông báo thành công nếu có
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'Đóng'
                    });
                @endif

                @if (session('violation_error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Vi phạm!',
                        text: '{{ session('violation_error') }}',
                        confirmButtonText: 'Đóng'
                    });
                @endif

                // Hiển thị cảnh báo vi phạm nếu có
                @if (auth()->user()->violation_count > 5)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cảnh báo vi phạm!',
                        html: '<div class="text-start"><p><strong>Tài khoản của bạn hiện có {{ auth()->user()->violation_count }} vi phạm.</strong></p>' +
                            '<p>Bạn không thể thực hiện các hành động liên quan đến bài viết cho đến khi số vi phạm giảm xuống dưới 5.</p>' +
                            '<p>Vui lòng liên hệ quản trị viên để được hỗ trợ.</p></div>',
                        confirmButtonText: 'Tôi đã hiểu',
                        confirmButtonColor: '#3085d6'
                    });
                @endif

                // Xử lý nút xóa bài viết
                document.querySelectorAll('.delete-article-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const articleId = this.getAttribute('data-article-id');
                        const articleTitle = this.getAttribute('data-article-title');
                        const form = this.closest('form');

                        // Kiểm tra vi phạm trước khi cho phép hành động
                        @if (auth()->user()->violation_count > 5)
                            Swal.fire({
                                icon: 'error',
                                title: 'Không thể thực hiện!',
                                html: '<div class="text-start"><p><strong>Tài khoản của bạn hiện có {{ auth()->user()->violation_count }} vi phạm.</strong></p>' +
                                    '<p>Bạn không thể xóa bài viết cho đến khi số vi phạm giảm xuống dưới 5.</p>' +
                                    '<p>Vui lòng liên hệ quản trị viên để được hỗ trợ.</p></div>',
                                confirmButtonText: 'Tôi đã hiểu',
                                confirmButtonColor: '#3085d6'
                            });
                        @else
                            Swal.fire({
                                title: 'Xóa bài viết?',
                                html: `Bạn có chắc chắn muốn xóa bài viết <strong>${articleTitle}</strong> không?<br>Hành động này không thể hoàn tác!`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Xóa',
                                cancelButtonText: 'Hủy'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Hiển thị thông báo đang xử lý
                                    Swal.fire({
                                        title: 'Đang xử lý...',
                                        text: 'Đang xóa bài viết, vui lòng đợi...',
                                        icon: 'info',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        showConfirmButton: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                    form.submit();
                                }
                            });
                        @endif
                    });
                });

                // Xử lý nút ẩn/hiện bài viết
                document.querySelectorAll('.toggle-visibility-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const action = this.getAttribute('data-action');
                        const form = this.closest('form');

                        // Kiểm tra vi phạm trước khi cho phép hành động
                        @if (auth()->user()->violation_count > 5)
                            Swal.fire({
                                icon: 'error',
                                title: 'Không thể thực hiện!',
                                html: '<div class="text-start"><p><strong>Tài khoản của bạn hiện có {{ auth()->user()->violation_count }} vi phạm.</strong></p>' +
                                    '<p>Bạn không thể ẩn/hiện bài viết cho đến khi số vi phạm giảm xuống dưới 5.</p>' +
                                    '<p>Vui lòng liên hệ quản trị viên để được hỗ trợ.</p></div>',
                                confirmButtonText: 'Tôi đã hiểu',
                                confirmButtonColor: '#3085d6'
                            });
                        @else
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
                                    // Hiển thị thông báo đang xử lý
                                    Swal.fire({
                                        title: 'Đang xử lý...',
                                        text: `Đang ${action} bài viết, vui lòng đợi...`,
                                        icon: 'info',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        showConfirmButton: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                    form.submit();
                                }
                            });
                        @endif
                    });
                });

                // Xử lý nút xin duyệt lại
                document.querySelectorAll('.request-review-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('form');
                        const articleId = this.getAttribute('data-article-id');

                        // Kiểm tra vi phạm trước khi cho phép hành động
                        @if (auth()->user()->violation_count > 5)
                            Swal.fire({
                                icon: 'error',
                                title: 'Không thể thực hiện!',
                                html: '<div class="text-start"><p><strong>Tài khoản của bạn hiện có {{ auth()->user()->violation_count }} vi phạm.</strong></p>' +
                                    '<p>Bạn không thể gửi lại bài viết để xin duyệt cho đến khi số vi phạm giảm xuống dưới 5.</p>' +
                                    '<p>Vui lòng liên hệ quản trị viên để được hỗ trợ.</p></div>',
                                confirmButtonText: 'Tôi đã hiểu',
                                confirmButtonColor: '#3085d6'
                            });
                        @else
                            Swal.fire({
                                title: 'Xin duyệt lại?',
                                text: 'Bài viết sẽ được gửi lại để xin duyệt. Bạn có muốn tiếp tục không?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Gửi lại',
                                cancelButtonText: 'Hủy'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Hiển thị thông báo đang xử lý
                                    Swal.fire({
                                        title: 'Đang xử lý...',
                                        text: 'Đang gửi lại bài viết để xin duyệt, vui lòng đợi...',
                                        icon: 'info',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        showConfirmButton: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                    form.submit();
                                }
                            });
                        @endif
                    });
                });

                // Xử lý nút thêm bài viết mới khi có vi phạm
                @if (auth()->user()->violation_count > 5)
                    const addNewArticleBtn = document.getElementById('addNewArticleBtn');
                    if (addNewArticleBtn) {
                        addNewArticleBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            Swal.fire({
                                icon: 'error',
                                title: 'Không thể thực hiện!',
                                html: '<div class="text-start"><p><strong>Tài khoản của bạn hiện có {{ auth()->user()->violation_count }} vi phạm.</strong></p>' +
                                    '<p>Bạn không thể thêm bài viết mới cho đến khi số vi phạm giảm xuống dưới 5.</p>' +
                                    '<p>Vui lòng liên hệ quản trị viên để được hỗ trợ.</p></div>',
                                confirmButtonText: 'Tôi đã hiểu',
                                confirmButtonColor: '#3085d6'
                            });
                        });
                    }
                @endif
            });
        </script>
    @endsection
