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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
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


                    </div>

                    <div class="box-body">
                        <div class="row mb-3">
                            <div class="col-md-6 text-end">
                                <span class="badge bg-info">Tổng số: {{ $violations->total() }} vi phạm</span>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('admin.violations.approves') }}" class="mb-3"
                            style="width: 150px;">
                            <div class="input-group">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ Xử Lý
                                    </option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Đã Xử
                                        Lý</option>
                                </select>
                            </div>
                        </form>

                        <!-- Hiển thị thông báo nếu có -->
                        @if (request('status'))
                            <div class="alert alert-info">
                                Hiển thị các vi phạm với trạng thái: <strong>{{ ucfirst(request('status')) }}</strong>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0" style="width:100%">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="15%">Loại Vi Phạm</th>
                                        <th width="10%">Bài Viết/Tham Chiếu</th>
                                        <th width="10%">Lý Do Vi Phạm</th>
                                        <th width="10%">Thời Gian Phát Hiện</th>
                                        <th width="10%">Người Xử Lý</th>
                                        <th width="10%">Trạng Thái</th>
                                        <th width="20%">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($violations as $violation)
                                        <tr>
                                            <td>{{ $violation->violation_id }}</td>
                                            <td>
                                                <strong>{{ $violation->type }}</strong>
                                                <div class="small text-muted">
                                                    {{ Str::limit($violation->reference_id, 30) }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#violationDetailsModal{{ $violation->violation_id }}">
                                                    Xem chi tiết
                                                </button>
                                            </td>


                                            </td>

                                            <td>
                                                <span class="text-danger">{{ $violation->detected_word }}</span>
                                            </td>
                                            <td class="text-center">{{ $violation->detected_at }}</td>
                                            <td>{{ $violation->handledByUser ? $violation->handledByUser->username : 'Chưa xử lý' }}
                                            </td>




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

                                            <td>
                                                <div class="d-flex flex-wrap gap-1 mb-2">

                                                    @if ($violation->status === 'pending')
                                                        <form action="{{ route('violations.resolve', $violation) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                title="Giải quyết vi phạm"
                                                                onclick="return confirm('Bạn có chắc chắn muốn giải quyết vi phạm này không?')">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('violations.reject', $violation) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                title="Từ chối vi phạm"
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
        @foreach ($violations as $violation)
            <!-- Modal for violation details -->
            <div class="modal fade" id="violationDetailsModal{{ $violation->violation_id }}" tabindex="-1"
                aria-labelledby="violationDetailsModalLabel{{ $violation->violation_id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="violationDetailsModalLabel{{ $violation->violation_id }}">
                                Chi tiết vi phạm - {{ $violation->violation_id }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Loại Vi Phạm: <strong>{{ $violation->type }}</strong></h6>
                            <p><strong>Lý Do Vi Phạm:</strong> {{ $violation->detected_word }}</p>
                            <p><strong>Thời Gian Phát Hiện:</strong> {{ $violation->detected_at }}</p>

                            <p><strong>Trạng Thái:</strong>
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
                            </p>

                            <h6>Bài Viết:</h6>
                            @if ($violation->article)
                                <p>
                                    <a href="{{ route('violations.resolve', $violation->article->slug) }}" target="_blank">
                                        {{ $violation->article->title }}
                                    </a>
                                </p>
                                <p><strong></strong> {!! $violation->article->content !!}</p>
                            @else
                                <p>Không có bài viết liên quan</p>
                            @endif



                            @if ($violation->comments && $violation->comments->count() > 0)
                                <div class="card mt-3">
                                    <div class="card-header bg-primary text-white">
                                        <strong>Bình luận liên quan</strong>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($violation->comments as $comment)
                                            <li class="list-group-item d-flex align-items-start">
                                                {{-- Avatar --}}
                                                <div style="width: 50px; height: 50px;" class="img img-cover icon-85 rounded-circle overflow-hidden flex-shrink-0 me-30">
                                                    <img src="{{ asset('storage/' . ($comment->user->avatar ?? 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg')) }}" 
                                                         alt="{{ $comment->user->username }}" 
                                                         onerror="this.onerror=null;this.src='https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg';">
                                                </div>
                                                
                                                
                                        
                                                <div>
                                                    {{-- Tên người dùng --}}
                                                    <p class="mb-1">
                                                        <strong>{{ $comment->user->username ?? 'Ẩn danh' }}</strong>
                                                    </p>
                                        
                                                    {{-- Nội dung bình luận --}}
                                                    <p class="mb-0">{{ $comment->content }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                        
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mt-3">Không có bình luận liên quan</div>
                            @endif



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            $(document).ready(function() {
                // Khi nhấn vào nút "Xem chi tiết"
                $('[data-bs-toggle="modal"]').on('click', function() {
                    var modalTarget = $(this).data('bs-target');
                    $(modalTarget).modal('show');
                });

                // Đóng tất cả modal khi nhấn chuyển trang
                $(document).on('click', '.pagination a', function() {
                    $('.modal').modal('hide');
                });
            });
        </script>
    @endsection
