@extends('admin.layouts.master')

@section('title')
    Chi Tiết Bài Viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Chi Tiết Bài Viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                    <li class="breadcrumb-item active" aria-current="page">Chi Tiết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="box">

                <div class="box-header with-border">
                    <h4 class="box-title">Chi Tiết Bài Viết</h4>
                    <div class="box-tools">
                        @if (auth()->id() === $article->author_id)
                            <div class="btn-group">
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm m-5">
                                    <i class="si-pencil si"></i> Chỉnh sửa
                                </a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                    class="d-inline m-5">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                        <i class="si-trash si"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        @endif

                        <a href="{{ route('articles.moderation-history', $article) }}" class="btn btn-info btn-sm m-5">
                            <i class="fas fa-history"></i> Lịch sử kiểm duyệt
                        </a>

                        <a href="{{ route('articles.index') }}" class="btn btn-default btn-sm m-5">
                            <i class="mdi mdi-arrow-left"></i> Quay lại
                        </a>

                    </div>
                </div>
                <div class="box-body">
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
                                            <p class="text-muted"><i class="mdi mdi-link-variant"></i> {{ $article->slug }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- <div class="row mb-4">
                                        <div class="col-md-12">
                                            <h5>Nội dung tóm tắt:</h5>
                                            <p>{{ $article->preview_content }}</p>
                                        </div>
                                    </div> --}}

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Nội dung chi tiết:</h5>
                                            <div class="bg-light p-3 rounded">
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
                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh đại diện"
                                            class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Thông tin khác</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-account"></i> Tác giả:</span>
                                            <span
                                                class="badge bg-primary rounded-pill">{{ $article->author->username ?? 'Không có' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-folder"></i> Danh mục:</span>
                                            <span
                                                class="badge bg-info rounded-pill">{{ $article->category->name ?? 'Không có' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-check-circle"></i> Trạng thái:</span>
                                            <span
                                                class="badge bg-{{ $article->status == 'published' ? 'success' : 'warning' }} rounded-pill">
                                                {{ ucfirst($article->status) }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-alert-circle"></i> Nội dung nhạy cảm:</span>
                                            <span
                                                class="badge bg-{{ $article->contains_sensitive_content ? 'danger' : 'success' }} rounded-pill">
                                                {{ $article->contains_sensitive_content ? 'Có' : 'Không' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-account-check"></i> Được duyệt bởi:</span>
                                            <span
                                                class="badge bg-dark rounded-pill">{{ $article->approver->username ?? 'Chưa được duyệt' }}</span>
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
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Tương Tác</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-eye"></i> Lượt xem:</span>
                                            <span class="badge bg-secondary rounded-pill">{{ $article->views }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-thumb-up"></i> Lượt thích:</span>
                                            <span
                                                class="badge bg-success rounded-pill">{{ $article->likes->count() }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-comment"></i> Bình luận:</span>
                                            <span
                                                class="badge bg-warning rounded-pill">{{ $article->comments->count() }}</span>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
