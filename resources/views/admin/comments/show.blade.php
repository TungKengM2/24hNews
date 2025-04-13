@extends('admin.layouts.master')

@section('title', 'Chi tiết bình luận')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Chi tiết bình luận</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Bình luận</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border d-flex justify-content-between align-items-center">
                            <h3 class="box-title">Thông tin bình luận</h3>
                            <div>
                                <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>

                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID:</strong> {{ $comment->comment_id }}</p>
                                    <p><strong>Người bình luận:</strong>
                                        @if($comment->user)
                                            {{ $comment->user->username }}
                                        @else
                                            <span class="text-muted">Không xác định</span>
                                        @endif
                                    </p>
                                    <p><strong>Bài viết:</strong>
                                        @if($comment->article)
                                            <a href="{{ route('articles.show', $comment->article) }}" target="_blank">
                                                {{ $comment->article->title }}
                                            </a>
                                        @else
                                            <span class="text-muted">Không xác định</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Trạng thái:</strong>
                                        @if($comment->status == 'approved')
                                            <span class="badge badge-success">Đã duyệt</span>
                                        @elseif($comment->status == 'rejected')
                                            <span class="badge badge-danger">Đã từ chối</span>
                                        @else
                                            <span class="badge badge-warning">{{ $comment->status }}</span>
                                        @endif
                                    </p>
                                    <p><strong>Thời gian tạo:</strong> {{ $comment->created_at->format('d/m/Y H:i:s') }}</p>
                                    <p><strong>Cập nhật lần cuối:</strong> {{ $comment->updated_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>Nội dung bình luận:</h5>
                                    <div class="p-3 bg-light">
                                        {!! $comment->content !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        @if($comment->status != 'approved')
                                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="mr-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-check"></i> Duyệt bình luận
                                                </button>
                                            </form>
                                        @endif

                                        @if($comment->status != 'rejected')
                                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="mr-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fa fa-ban"></i> Từ chối bình luận
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                                <i class="fa fa-trash"></i> Xóa bình luận
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</div>
@endsection
