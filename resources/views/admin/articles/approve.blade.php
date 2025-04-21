@extends('admin.layouts.master')

@section('title')
    Duyệt bài viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Duyệt bài viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Duyệt bài viết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="container-full">
                <div class="col-12">
                    <div class="box"></div>
                    <div class="box-header with-border d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-default">
                                <i class="fa fa-arrow-left me-1"></i> Quay Lại Bảng Điều Khiển
                            </a>
                        </div>

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

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const searchInput = document.getElementById('searchInput');
                                const categoryFilter = document.getElementById('categoryFilter');
                                const authorFilter = document.getElementById('authorFilter');
                                const searchButton = document.getElementById('searchButton');
                                const articleRows = document.querySelectorAll('tbody tr');

                                function performSearch() {
                                    const searchTerm = searchInput.value.toLowerCase().trim();
                                    const categorySearchTerm = categoryFilter.value.toLowerCase().trim();
                                    const authorSearchTerm = authorFilter.value.toLowerCase().trim();

                                    articleRows.forEach(row => {
                                        const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                                        const category = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                                        const author = row.querySelector('td:nth-child(6)').textContent.toLowerCase();

                                        const matchesTitle = title.includes(searchTerm);
                                        const matchesCategory = !categorySearchTerm || category.includes(categorySearchTerm);
                                        const matchesAuthor = !authorSearchTerm || author.includes(authorSearchTerm);

                                        if (matchesTitle && matchesCategory && matchesAuthor) {
                                            row.style.display = '';
                                        } else {
                                            row.style.display = 'none';
                                        }
                                    });
                                }

                                // Search on button click
                                searchButton.addEventListener('click', performSearch);

                                // Search on Enter key press
                                [searchInput, categoryFilter, authorFilter].forEach(input => {
                                    input.addEventListener('keyup', function(event) {
                                        if (event.key === 'Enter') {
                                            performSearch();
                                        }
                                    });

                                    // Real-time search as user types
                                    input.addEventListener('input', performSearch);
                                });
                            });
                        </script>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row mb-3">
                            <div class="col-md-6 text-end">
                                <span class="badge bg-info">Tổng số: {{ $articles->total() }} bài viết</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0" style="width:100%">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="15%">Tiêu Đề</th>
                                        <th width="10%">Hình Ảnh</th>
                                        <th width="10%">Danh Mục</th>
                                        <th width="10%">Trạng Thái</th>
                                        <th width="10%">Tác Giả</th>
                                        {{-- <th width="10%">Nội Dung Nhạy Cảm</th> --}}
                                        <th width="10%">Thẻ</th>
                                        <th width="20%">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articles as $article)
                                        <tr>
                                            <td>{{ $article->article_id }}</td>
                                            <td>
                                                <strong>{{ $article->title }}</strong>
                                                <div class="small text-muted">{{ Str::limit($article->slug, 30) }}</div>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh"
                                                    class="img-thumbnail" width="80" height="80">
                                            </td>
                                            <td>
                                                @if ($article->category)
                                                    @if (!$article->category->is_active)
                                                        <span class="text-warning">{{ $article->category->name }} <i
                                                                class="fa fa-exclamation-triangle"></i></span>
                                                    @else
                                                        <span class="badge bg-info">{{ $article->category->name }}</span>
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
                                            <td>{{ $article->author->username ?? 'Chưa xác định' }}</td>
                                            {{-- <td class="text-center">
                                                    @if ($article->contains_sensitive_content)
                                                        <span class="badge bg-danger">Có</span>
                                                    @else
                                                        <span class="badge bg-success">Không</span>
                                                    @endif
                                                </td> --}}
                                            <td class="text-center">
                                                @if ($article->tags->isNotEmpty())
                                                    @foreach ($article->tags as $tag)
                                                        <span class="badge bg-primary">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <small class="text-muted">Không có thẻ</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1 mb-2">
                                                    <button type="button" class="btn btn-info btn-sm" title="Xem chi tiết"
                                                        data-bs-toggle="modal" data-bs-target="#articleDetailModal{{ $article->article_id }}">
                                                        <i class="si-eye si"></i>
                                                    </button>

                                                    <a href="{{ route('articles.moderation-history', $article) }}"
                                                        class="btn btn-secondary btn-sm" title="Lịch sử kiểm duyệt">
                                                        <i class="fas fa-history"></i>
                                                    </a>

                                                    @if ($article->status === 'pending')
                                                        <form action="{{ route('articles.approve', $article) }}"
                                                            method="POST" class="d-inline" id="approveForm{{ $article->article_id }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="button" class="btn btn-success btn-sm approve-btn"
                                                                title="Duyệt bài viết" data-id="{{ $article->article_id }}">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('articles.reject', $article) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                title="Từ chối bài viết"
                                                                data-bs-toggle="modal" data-bs-target="#rejectModal{{ $article->article_id }}">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Từ chối bài viết -->
                                        <div class="modal fade" id="rejectModal{{ $article->article_id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $article->article_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel{{ $article->article_id }}">Từ chối bài viết</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('articles.reject', $article) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="rejection_reason{{ $article->article_id }}" class="form-label">Lý do từ chối</label>
                                                                <textarea class="form-control" id="rejection_reason{{ $article->article_id }}" name="rejection_reason" rows="3" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

                                <!-- Article Detail Modals -->
                                @foreach ($articles as $article)
                                <div class="modal fade" id="articleDetailModal{{ $article->article_id }}" tabindex="-1" aria-labelledby="articleDetailModalLabel{{ $article->article_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="articleDetailModalLabel{{ $article->article_id }}">Chi tiết bài viết: {{ $article->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <!-- Thông tin cơ bản -->
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Thông tin cơ bản</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-12">
                                                                        <h4><i class="mdi mdi-title"></i> {{ $article->title }}</h4>
                                                                        <p class="text-muted"><i class="mdi mdi-link-variant"></i> {{ $article->slug }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h5>Nội dung chi tiết:</h5>
                                                                        <div class="bg-light p-3 rounded article-content-{{ $article->article_id }}">
                                                                            {!! $article->content !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Thông tin bổ sung -->
                                                    <div class="col-md-4">
                                                        @if ($article->thumbnail_url)
                                                            <div class="card mb-4">
                                                                <div class="card-header">
                                                                    <h5 class="card-title mb-0">Ảnh đại diện</h5>
                                                                </div>
                                                                <div class="card-body text-center">
                                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh đại diện" class="img-fluid rounded" style="max-height: 200px;">
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <!-- Tiêu chí xuất bản -->
                                                        <div class="card mb-4">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Tiêu chí xuất bản</h5>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <div class="verification-criteria">

                                                                    <div class="criteria-content">
                                                                        <ul class="criteria-list" id="criteria-list-{{ $article->article_id }}">
                                                                            <li class="criteria-item failed" id="criteria-title-{{ $article->article_id }}" data-target="title">
                                                                                <div class="criteria-icon failed">✗</div>
                                                                                <div class="criteria-text criteria-tooltip">
                                                                                    Tiêu đề từ 50-60 ký tự <span id="current-title-length-{{ $article->article_id }}">(0 ký tự)</span>
                                                                                    <span class="tooltip-text">Tiêu đề trong khoảng 50-60 ký tự sẽ hiển thị đầy đủ trên Google và tối ưu cho SEO</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="criteria-item failed" id="criteria-category-{{ $article->article_id }}" data-target="parent_category">
                                                                                <div class="criteria-icon failed">✗</div>
                                                                                <div class="criteria-text criteria-tooltip">
                                                                                    Chọn danh mục chính và phụ
                                                                                    <span class="tooltip-text">Bắt buộc chọn cả danh mục chính và danh mục phụ phù hợp với nội dung bài viết</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="criteria-item failed" id="criteria-tags-{{ $article->article_id }}" data-target="tags">
                                                                                <div class="criteria-icon failed">✗</div>
                                                                                <div class="criteria-text criteria-tooltip">
                                                                                    Chọn 2-5 thẻ tag liên quan <span id="current-tag-count-{{ $article->article_id }}">(0 thẻ)</span>
                                                                                    <span class="tooltip-text">Thẻ tag phù hợp giúp phân loại bài viết và tăng khả năng xuất hiện trong tìm kiếm</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="criteria-item failed" id="criteria-thumbnail-{{ $article->article_id }}" data-target="thumbnail_url">
                                                                                <div class="criteria-icon failed">✗</div>
                                                                                <div class="criteria-text criteria-tooltip">
                                                                                    Ảnh đại diện chất lượng cao
                                                                                    <span class="tooltip-text">Ảnh đại diện rõ nét, liên quan đến nội dung bài viết và không vi phạm bản quyền</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="criteria-item failed" id="criteria-content-{{ $article->article_id }}" data-target="content">
                                                                                <div class="criteria-icon failed">✗</div>
                                                                                <div class="criteria-text criteria-tooltip">
                                                                                    Nội dung từ 800-1500 từ <span id="current-word-count-{{ $article->article_id }}">(0 từ)</span>
                                                                                    <span class="tooltip-text">Nội dung đủ dài để cung cấp thông tin đầy đủ nhưng không quá dài gây mất tập trung</span>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                        <div class="criteria-progress mt-3">
                                                                            <div class="progress">
                                                                                <div class="progress-bar bg-success" id="criteria-progress-bar-{{ $article->article_id }}" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                            <div class="criteria-count">
                                                                                <small id="criteria-count-{{ $article->article_id }}">0/5 tiêu chí đạt</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Thông tin khác</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span><i class="mdi mdi-account"></i> Tác giả:</span>
                                                                        <span class="badge bg-primary rounded-pill">{{ $article->author->username ?? 'Không có' }}</span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span><i class="mdi mdi-folder"></i> Danh mục chính:</span>
                                                                        <span class="badge bg-info rounded-pill">{{ $article->category->name ?? 'Không có' }}</span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span><i class="mdi mdi-folder-outline"></i> Danh mục phụ:</span>
                                                                        <span class="badge bg-secondary rounded-pill">{{ $article->subcategory->name ?? 'Không có' }}</span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span><i class="mdi mdi-check-circle"></i> Trạng thái:</span>
                                                                        <span class="badge bg-{{ $article->status == 'published' ? 'success' : 'warning' }} rounded-pill">
                                                                            {{ ucfirst($article->status) }}
                                                                        </span>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <span><i class="mdi mdi-tag-multiple"></i> Thẻ:</span>
                                                                        <div class="mt-2">
                                                                            @if ($article->tags->isNotEmpty())
                                                                                @foreach ($article->tags as $tag)
                                                                                    <span class="badge bg-primary m-1">{{ $tag->name }}</span>
                                                                                @endforeach
                                                                            @else
                                                                                <span class="text-muted">Không có thẻ</span>
                                                                            @endif
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                @if ($article->status === 'pending')
                                                    <form action="{{ route('articles.approve', $article) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success" title="Duyệt bài viết"
                                                            onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                                            <i class="fa fa-check me-1"></i> Duyệt bài viết
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-danger" title="Từ chối bài viết"
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $article->article_id }}" data-bs-dismiss="modal">
                                                        <i class="fa fa-times me-1"></i> Từ chối bài viết
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection

@section('styles')
<style>
    /* Styles for verification criteria */
    .verification-criteria {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .verification-criteria-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .criteria-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .criteria-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e9ecef;
    }

    .criteria-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .criteria-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-weight: bold;
    }

    .criteria-icon.passed {
        background-color: #28a745;
        color: white;
    }

    .criteria-icon.failed {
        background-color: #dc3545;
        color: white;
    }

    .criteria-text {
        flex: 1;
        font-size: 14px;
        position: relative;
    }

    .criteria-tooltip {
        cursor: help;
    }

    .criteria-tooltip .tooltip-text {
        visibility: hidden;
        width: 250px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 8px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 0;
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 12px;
    }

    .criteria-tooltip:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Progress bar styles */
    .criteria-progress {
        margin-top: 15px;
        width: 100%;
    }

    .criteria-progress .progress {
        height: 10px;
        border-radius: 5px 5px 0 0;
        background-color: #e9ecef;
        margin-bottom: 0;
        overflow: hidden;
        width: 100%;
        display: block;
    }

    .criteria-progress .progress-bar {
        height: 100%;
        transition: width 0.3s ease;
        float: left;
    }
    
    .criteria-count {
        background-color: #f8f9fa;
        border-radius: 0 0 5px 5px;
        padding: 5px;
        text-align: center;
        border: none;
        font-size: 12px;
        color: #495057;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý nút duyệt bài viết với SweetAlert2
        const approveButtons = document.querySelectorAll('.approve-btn');
        
        approveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const articleId = this.getAttribute('data-id');
                const form = document.getElementById('approveForm' + articleId);
                
                Swal.fire({
                    title: 'Xác nhận duyệt bài',
                    text: 'Bạn có chắc chắn muốn duyệt bài viết này không?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý, duyệt bài!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
