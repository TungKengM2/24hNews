@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Chi tiết yêu cầu chỉnh sửa</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.article-edit-requests.index') }}">Yêu cầu chỉnh sửa</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết yêu cầu</li>
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
                            <h4 class="box-title">Yêu cầu chỉnh sửa #{{ $request->id }}</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.article-edit-requests.index') }}" class="btn btn-default btn-sm">
                                    <i class="fa fa-arrow-left me-1"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">Thông tin bài viết</h4>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th style="width: 30%">ID</th>
                                                    <td>{{ $request->article->article_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tiêu đề</th>
                                                    <td>
                                                        <a href="{{ route('articles.show', $request->article) }}" target="_blank">
                                                            {{ $request->article->title }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Danh mục</th>
                                                    <td>{{ $request->article->category->name ?? 'Không có danh mục' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Trạng thái</th>
                                                    <td>
                                                        @switch($request->article->status)
                                                            @case('draft')
                                                                <span class="badge bg-secondary">Bản nháp</span>
                                                                @break
                                                            @case('pending')
                                                                <span class="badge bg-warning">Chờ duyệt</span>
                                                                @break
                                                            @case('published')
                                                                <span class="badge bg-success">Đã đăng</span>
                                                                @break
                                                            @case('archived')
                                                                <span class="badge bg-info">Đã lưu trữ</span>
                                                                @break
                                                            @case('rejected')
                                                                <span class="badge bg-danger">Từ chối</span>
                                                                @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">Thông tin tác giả</h4>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th style="width: 30%">ID</th>
                                                    <td>{{ $request->author->user_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tên</th>
                                                    <td>{{ $request->author->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $request->author->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Thời gian yêu cầu</th>
                                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">Lý do yêu cầu chỉnh sửa</h4>
                                        </div>
                                        <div class="box-body">
                                            <div class="p-3 bg-light rounded">
                                                {{ $request->reason }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($request->status === 'pending')
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">Xử lý yêu cầu</h4>
                                            </div>
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <form action="{{ route('admin.article-edit-requests.approve', $request) }}" method="POST">
                                                            @csrf
                                                            <div class="form-group mb-3">
                                                                <label for="approve_note">Ghi chú phê duyệt (nếu có)</label>
                                                                <textarea class="form-control" id="approve_note" name="admin_note" rows="3" placeholder="Nhập ghi chú phê duyệt nếu cần"></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fa fa-check-circle me-1"></i> Phê duyệt yêu cầu
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <form action="{{ route('admin.article-edit-requests.reject', $request) }}" method="POST">
                                                            @csrf
                                                            <div class="form-group mb-3">
                                                                <label for="reject_note">Lý do từ chối <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" id="reject_note" name="admin_note" rows="3" placeholder="Nhập lý do từ chối yêu cầu" required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fa fa-times-circle me-1"></i> Từ chối yêu cầu
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <h4 class="box-title">Kết quả xử lý</h4>
                                            </div>
                                            <div class="box-body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="width: 20%">Trạng thái</th>
                                                        <td>
                                                            @if($request->status === 'approved')
                                                                <span class="badge bg-success">Đã phê duyệt</span>
                                                            @elseif($request->status === 'rejected')
                                                                <span class="badge bg-danger">Đã từ chối</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Người xử lý</th>
                                                        <td>{{ $request->processor->name ?? 'Không có thông tin' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Thời gian xử lý</th>
                                                        <td>{{ $request->processed_at ? $request->processed_at->format('d/m/Y H:i') : 'Không có thông tin' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ghi chú</th>
                                                        <td>{{ $request->admin_note ?? 'Không có ghi chú' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
