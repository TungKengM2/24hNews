@extends('admin.layouts.master')

@section('title', 'Quản lý bình luận')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Quản lý bình luận</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bình luận</li>
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
                        <div class="box-header with-border">
                            <h3 class="box-title">Danh sách bình luận</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nội dung</th>
                                            <th>Người bình luận</th>
                                            <th>Bài viết</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($comments as $comment)
                                            <tr>
                                                <td>{{ $comment->comment_id }}</td>
                                                <td>{{ Str::limit(strip_tags($comment->content), 50) }}</td>
                                                <td>
                                                    @if($comment->user)
                                                        {{ $comment->user->username }}
                                                    @else
                                                        <span class="text-muted">Không xác định</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($comment->article)
                                                        <a href="{{ route('articles.show', $comment->article) }}" target="_blank">
                                                            {{ Str::limit($comment->article->title, 30) }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Không xác định</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($comment->status == 'approved')
                                                        <span class="badge badge-success">Đã duyệt</span>
                                                    @elseif($comment->status == 'rejected')
                                                        <span class="badge badge-danger">Đã từ chối</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ $comment->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $comment->created_at->format('d/m/Y H:i:s') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('comments.moderation-history', $comment) }}" class="btn btn-secondary btn-sm" title="Lịch sử kiểm duyệt">
                                                            <i class="fa fa-history"></i>
                                                        </a>
                                                        @if($comment->status != 'approved')
                                                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm" title="Duyệt bình luận">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if($comment->status != 'rejected')
                                                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-warning btn-sm" title="Từ chối bình luận">
                                                                    <i class="fa fa-ban"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa bình luận" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $comments->links() }}
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
