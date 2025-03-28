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
                        <div class="box-header">


                            <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                    href="{{ route('moderator.dashboard') }}">
                                    Quay lại Trang Chủ
                                </a></button>
                            {{-- <button type="button" class="waves-effect waves-light btn btn-primary mb-5"> <a
                                    href="{{ route('articles.create') }}">
                                    <i class="si-plus si"></i>
                                </a></button> --}}

                            {{-- <form method="GET" action="{{ route('articles.index') }}">
                                <div class="d-flex align-items-center mb-3">
                                    <label for="filter" class="me-2">Lọc bài viết:</label>
                                    <select name="filter" class="form-control w-auto" onchange="this.form.submit()">
                                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Tất cả bài
                                            viết</option>
                                        <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Bài
                                            viết có danh mục hoạt động</option>
                                        <option value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>Bài
                                            viết có danh mục bị vô hiệu hóa</option>
                                        <option value="no_category"
                                            {{ request('filter') == 'no_category' ? 'selected' : '' }}>Bài viết không có
                                            danh mục</option>
                                    </select>
                                </div>
                            </form> --}}


                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tiêu Đề</th>
                                            <th>Slug</th>
                                            <th>Chứa Nội Dung Nhạy Cảm</th>
                                            <th>Tác Giả</th>
                                            <th>Danh Mục</th>
                                            <th>Ảnh Đại Diện</th>
                                            <th>Trạng Thái</th>
                                            <th>Lượt Xem</th>
                                            <th>Thẻ</th>
                                            <th>Người Duyệt</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articles as $article)
                                            <tr>
                                                <td>{{ $article->article_id }}</td>
                                                <td>{{ $article->title }}</td>
                                                <td>{{ $article->slug }}</td>
                                                <td class="text-center">
                                                    @if ($article->contains_sensitive_content)
                                                        <span class="badge bg-danger">Có</span>
                                                    @else
                                                        <span class="badge bg-success">Không</span>
                                                    @endif
                                                </td>
                                                <td>{{ $article->author->username ?? 'Unknown' }}</td>
                                                <td>
                                                    @if ($article->category)
                                                        @if (!$article->category->is_active)
                                                            <span class="text-warning">{{$article->category->name}} (Không Hoạt Động)</span>
                                                        @else
                                                            {{ $article->category->name }}
                                                        @endif
                                                    @else
                                                        <span class="text-danger">Không có danh mục</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                        alt="Thumbnail" width="100" height="150">

                                                </td>
                                                <td>
                                                    @switch($article->status)
                                                        @case('draft')
                                                            <span class="badge bg-secondary">Nháp</span>
                                                        @break

                                                        @case('pending')
                                                            <span class="badge bg-warning">Chờ Duyệt</span>
                                                        @break

                                                        @case('published')
                                                            <span class="badge bg-success">Đã Xuất Bản</span>
                                                        @break

                                                        @case('archived')
                                                            <span class="badge bg-danger">Đã Lưu Trữ</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>{{ $article->views }}</td>
                                                <td>
                                                    @if ($article->tags->isNotEmpty())
                                                        @foreach ($article->tags as $tag)
                                                            <span class="badge bg-primary">{{ $tag->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">Không có thẻ</span>
                                                    @endif
                                                </td>
                                                <td>{{ $article->approved_by ? $article->approver->username : 'Chưa Duyệt' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('moderator.articles.show', $article) }}" class="btn btn-info btn-sm">
                                                        <i class="si-eye si"></i>
                                                    </a>

                                                    @if ($article->status === 'pending')
                                                        <form action="{{ route('moderator.articles.approve', $article) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                                                Approve
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('moderator.articles.reject', $article) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Bạn có chắc chắn muốn từ chối bài viết này không?')">
                                                                Reject
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>



                                                    {{-- <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                                            <i class="si-trash si"></i>
                                                        </button>
                                                    </form> --}}

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                                    <nav>
                                        <ul class="pagination pagination-sm">
                                            {{ $articles->links('pagination::bootstrap-5') }}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function filterArticles() {
                        let filter = document.getElementById("filter").value;
                        window.location.href = "?filter=" + filter;
                    }
                </script>
            </div>
            <!-- /.content-wrapper -->
        </div>
    </div>
@endsection
