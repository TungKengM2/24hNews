@extends('admin.layouts.master')

@section('title')
    Chi Tiết Phiên Bản
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Chi Tiết Phiên Bản</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.articles.versions', $article) }}">Lịch Sử Phiên Bản</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Chi Tiết Phiên Bản</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Chi tiết phiên bản - {{ $version->version_id }}</h4>
                    <div class="box-tools">
                        <div class="btn-group">
                            <a href="{{ route('admin.articles.versions', $article) }}" class="btn btn-info btn-sm me-2">
                                <i class="si-list si"></i> Danh sách phiên bản
                            </a>
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm me-2">
                                <i class="si-pencil si"></i> Chỉnh sửa bài viết
                            </a>
                            <a href="{{ route('articles.index') }}" class="btn btn-default btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Thông tin chung</h4>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px">Mã phiên bản:</th>
                                            <td>{{ $version->version_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Người chỉnh sửa:</th>
                                            <td>{{ $version->user->username }}</td>
                                        </tr>
                                        <tr>
                                            <th>Thời gian:</th>
                                            <td>{{ $version->created_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lý do thay đổi:</th>
                                            <td>{{ $version->change_reason }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Nội dung bài viết</h4>
                                </div>
                                <div class="box-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tiêu đề</label>
                                        <input type="text" class="form-control" value="{{ $version->title }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" class="form-control" value="{{ $version->slug }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Danh mục chính</label>
                                        <input type="text" class="form-control"
                                            value="{{ $version->category ? $version->category->name : 'Không có danh mục' }}"
                                            readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Danh mục phụ</label>
                                        <input type="text" class="form-control"
                                            value="{{ $version->subcategory ? $version->subcategory->name : 'Không có danh mục phụ' }}"
                                            readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Ảnh đại diện</label>
                                        @if ($version->featured_image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $version->featured_image) }}"
                                                    alt="Ảnh đại diện" class="img-fluid" style="max-width: 300px;">
                                            </div>
                                        @else
                                            <p class="text-muted">Không có ảnh đại diện</p>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Tags</label>
                                        @if ($version->tags && count($version->tags) > 0)
                                            <div class="mt-2">
                                                @foreach ($version->tags as $tag)
                                                    <span class="badge bg-info me-1">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Không có tags</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Nội dung</label>
                                        <div class="border rounded p-3 bg-light">
                                            {!! $version->content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
