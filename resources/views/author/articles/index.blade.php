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
                                <a href="{{ route('author.articles.create') }}" class="btn btn-primary ms-2">
                                    <i class="si-plus si me-1"></i> Thêm Bài Viết Mới
                                </a>
                            </div>

                            @if (session('success'))
                                <div id="success-alert" class="alert alert-success alert-dismissible fade show custom-alert m-0">
                                    <div class="d-flex align-items-center">
                                        <div class="alert-icon me-2">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="alert-message">
                                            <p class="mb-0"><strong>Thành công!</strong> {{ session('success') }}</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="d-flex">
                                <div class="input-group me-2">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}">
                                    <button type="button" class="btn btn-primary" id="searchButton">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const searchInput = document.getElementById('searchInput');
                                    const searchButton = document.getElementById('searchButton');
                                    const articleRows = document.querySelectorAll('tbody tr');

                                    function performSearch() {
                                        const searchTerm = searchInput.value.toLowerCase().trim();
                                        
                                        articleRows.forEach(row => {
                                            const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                                            if (title.includes(searchTerm)) {
                                                row.style.display = '';
                                            } else {
                                                row.style.display = 'none';
                                            }
                                        });
                                    }

                                    // Search on button click
                                    searchButton.addEventListener('click', performSearch);

                                    // Search on Enter key press
                                    searchInput.addEventListener('keyup', function(event) {
                                        if (event.key === 'Enter') {
                                            performSearch();
                                        }
                                    });

                                    // Real-time search as user types
                                    searchInput.addEventListener('input', performSearch);
                                });
                            </script>

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
                                0% { opacity: 0; }
                                100% { opacity: 1; }
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
                                console.log('Hiển thị thông báo thành công: {{ session("success") }}');
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

                                                        <a href="{{ route('author.articles.edit', $article) }}"
                                                            class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                            <i class="si-pencil si"></i>
                                                        </a>

                                                        @if (in_array($article->status, ['published', 'archived']))
                                                        <form action="{{ route('author.articles.toggle-visibility', $article) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-secondary btn-sm"
                                                                title="{{ $article->status === 'published' ? 'Ẩn bài viết' : 'Hiện bài viết' }}"
                                                                onclick="return confirm('Bạn có chắc chắn muốn {{ $article->status === 'published' ? 'ẩn' : 'hiện' }} bài viết này không?')">
                                                                <i class="fa {{ $article->status === 'published' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                            </button>
                                                        </form>
                                                        @endif

                                                        <form action="{{ route('author.articles.destroy', $article) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" title="Xóa bài viết"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
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
                                        {{ $articles->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
