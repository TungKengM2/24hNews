@extends('moderator.layouts.master')

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
                                    <li class="breadcrumb-item"><a href="{{ route('moderator.dashboard') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Viết Chờ Duyệt</li>
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
                                <a href="{{ route('moderator.dashboard') }}" class="btn btn-default">
                                    <i class="fa fa-arrow-left me-1"></i> Quay Lại Trang Chủ
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
                                            <th class="text-center" width="5%">ID</th>
                                            <th class="text-center" width="15%">Tiêu Đề</th>
                                            <th class="text-center" width="10%">Hình Ảnh</th>
                                            <th class="text-center" width="10%">Danh Mục</th>
                                            <th class="text-center" width="10%">Trạng Thái</th>
                                            <th class="text-center" width="10%">Tác Giả</th>
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
                                                    <div class="small text-muted">{{ Str::limit($article->slug, 30) }}</div>
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
                                                    @endswitch
                                                </td>
                                                <td>{{ $article->author->username ?? 'Chưa xác định' }}</td>
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
                                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                                        <a href="{{ route('moderator.articles.show', $article) }}"
                                                            class="btn btn-info btn-sm" title="Xem chi tiết">
                                                            <i class="si-eye si"></i>
                                                        </a>
                                                        <a href="{{ route('moderator.articles.moderation-history', $article) }}"
                                                            class="btn btn-secondary btn-sm" title="Lịch sử kiểm duyệt">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                        @if ($article->status === 'pending')
                                                            <form
                                                                action="{{ route('moderator.articles.approve', $article) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                    title="Duyệt bài viết"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </form>

                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                title="Từ chối bài viết" data-bs-toggle="modal"
                                                                data-bs-target="#rejectModal{{ $article->article_id }}">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                            <!-- Modal Từ chối bài viết -->
                                                            <div class="modal fade"
                                                                id="rejectModal{{ $article->article_id }}" tabindex="-1"
                                                                aria-labelledby="rejectModalLabel{{ $article->article_id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form
                                                                            action="{{ route('moderator.articles.reject', $article) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="rejectModalLabel{{ $article->article_id }}">
                                                                                    Từ chối bài viết</h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="rejection_reason{{ $article->article_id }}">Lý
                                                                                        do từ chối</label>
                                                                                    <textarea class="form-control" id="rejection_reason{{ $article->article_id }}" name="rejection_reason"
                                                                                        rows="3" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Xác nhận từ
                                                                                    chối</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                        <form action="{{ route('moderator.articles.reject', $article) }}" method="POST">
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
                                                    <td colspan="9" class="text-center">Không có bài viết nào</td>
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
