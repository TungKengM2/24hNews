@extends('author.layouts.master')

@section('title')
    Lịch Sử Phiên Bản
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Lịch Sử Phiên Bản</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('author.articles.index') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                    <li class="breadcrumb-item active" aria-current="page">Lịch Sử Phiên Bản</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Lịch sử phiên bản - {{ $article->title }}</h4>
                    <div class="box-tools">
                        <div class="btn-group">
                            <a href="{{ route('author.articles.edit', $article) }}" class="btn btn-warning btn-sm me-2">
                                <i class="si-pencil si"></i> Chỉnh sửa bài viết
                            </a>
                            <a href="{{ route('author.articles.index') }}" class="btn btn-default btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mã phiên bản</th>
                                    <th>Tiêu đề</th>
                                    <th>Người chỉnh sửa</th>
                                    <th>Lý do thay đổi</th>
                                    <th>Thay đổi</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($versions as $key => $version)
                                <tr>
                                    <td>{{ $version->version_id }}</td>
                                    <td>{{ $version->title }}</td>
                                    <td>{{ $version->user->username }}</td>
                                    <td>{{ $version->change_reason }}</td>
                                    <td>
                                        @if($key < count($versions) - 1)
                                            @php
                                                $changes = [];
                                                $previousVersion = $versions[$key + 1];

                                                if($version->title !== $previousVersion->title) {
                                                    $changes[] = "Tiêu đề đã thay đổi";
                                                }
                                                if($version->slug !== $previousVersion->slug) {
                                                    $changes[] = "Đường dẫn đã thay đổi";
                                                }
                                                if($version->content !== $previousVersion->content) {
                                                    $changes[] = "Nội dung đã thay đổi";
                                                }
                                                if($version->category_id !== $previousVersion->category_id) {
                                                    $changes[] = "Danh mục đã thay đổi";
                                                }
                                                if($version->featured_image !== $previousVersion->featured_image) {
                                                    $changes[] = "Ảnh đại diện đã thay đổi";
                                                }
                                                if($version->tags !== $previousVersion->tags) {
                                                    $changes[] = "Tags đã thay đổi";
                                                }
                                            @endphp
                                            @if(count($changes) > 0)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach($changes as $change)
                                                        <li><span class="badge bg-info">{{ $change }}</span></li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">Không có thay đổi</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Phiên bản đầu tiên</span>
                                        @endif
                                    </td>
                                    <td>{{ $version->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('author.articles.version', [$article, $version->version_id]) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="si-eye si"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge {
            font-size: 0.85em;
            padding: 5px 10px;
            margin-bottom: 3px;
            display: inline-block;
        }
        .list-unstyled {
            margin-bottom: 0;
        }
        .list-unstyled li {
            margin-bottom: 3px;
        }
        .list-unstyled li:last-child {
            margin-bottom: 0;
        }
    </style>
@endsection
