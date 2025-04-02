@extends('admin.layouts.master')

@section('title')
    Duyệt report
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Duyệt report</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Duyệt report</li>
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
                                <form method="GET" action="{{ route('articles.index') }}" class="me-2">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bài viết..." 
                                            value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="row mb-3">
                                <div class="col-md-6 text-end">
                                    <span class="badge bg-info">Tổng số: {{ $violations->total() }} vi phạm</span>

                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="15%">Loại Vi Phạm</th>
                                            <th width="10%">Bài Viết/Tham Chiếu</th>
                                            <th width="10%">Từ Ngữ Phát Hiện</th>
                                            <th width="10%">Thời Gian Phát Hiện</th>
                                            <th width="10%">Người Xử Lý</th>
                                            <th width="10%">Trạng Thái</th>
                                            <th width="10%">Cảnh Báo Đã Gửi</th>
                                            <th width="20%">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($violations as $violation)
                                            <tr>
                                                <td>{{ $violation->violation_id }}</td>
                                                <td>
                                                    <strong>{{ $violation->type }}</strong>
                                                    <div class="small text-muted">{{ Str::limit($violation->reference_id, 30) }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.violations.approves', $violation->reference_id) }}" target="_blank">Xem bài viết</a>
                                                </td>
                                                <td>
                                                    <span class="text-danger">{{ $violation->detected_word }}</span>
                                                </td>
                                                <td class="text-center">{{ $violation->detected_at }}</td>
                                                <td>{{ $violation->handled_by ?? 'Chưa xử lý' }}</td>
                                                <td class="text-center">
                                                    @switch($violation->status)
                                                        @case('pending')
                                                            <span class="badge bg-warning">Chờ Xử Lý</span>
                                                            @break
                                                        @case('resolved')
                                                            <span class="badge bg-success">Đã Xử Lý</span>
                                                            @break
                                                        @case('archived')
                                                            <span class="badge bg-danger">Đã Lưu Trữ</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">Chưa Xử Lý</span>
                                                    @endswitch
                                                </td>
                                                <td class="text-center">
                                                    @if ($violation->warning_sent)
                                                        <span class="badge bg-info">Đã gửi</span>
                                                    @else
                                                        <span class="badge bg-danger">Chưa gửi</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                    
                                                        @if ($violation->status === 'pending')
                                                            <form action="{{ route('admin.violations.approves', $violation) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm" title="Giải quyết vi phạm"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn giải quyết vi phạm này không?')">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </form>
                                    
                                                            <form action="{{ route('admin.violations.approves', $violation) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Từ chối vi phạm"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn từ chối vi phạm này không?')">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Không có vi phạm nào</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    
                                </table>
                                <div class="d-flex justify-content-end mt-4">
                                    {{ $violations->links('pagination::bootstrap-5') }}
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
