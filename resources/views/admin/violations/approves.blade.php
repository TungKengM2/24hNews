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
                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                style="background-color: #4CAF50; color: white;">
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
                                                <strong>
                                                    @if ($violation->type === 'comment')
                                                        Bình luận
                                                    @elseif ($violation->type === 'article')
                                                        Bài viết
                                                    @else
                                                        {{ $violation->type }}
                                                    @endif
                                                </strong>
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
                                                        @if ($violation->type === 'comment')
                                                            <!-- Form giải quyết vi phạm cho comment -->
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
                                                        @elseif ($violation->type === 'article')
                                                            <!-- Form giải quyết vi phạm cho article -->
                                                            <form action="{{ route('violations.resolves', $violation) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                    title="Giải quyết vi phạm "
                                                                    onclick="return confirm('Bạn có chắc chắn muốn giải quyết vi phạm bài viết này không?')">
                                                                    <i class="fa fa-check"></i> 
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('violations.reject', $violation) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    title="Từ chối vi phạm "
                                                                    onclick="return confirm('Bạn có chắc chắn muốn từ chối vi phạm bài viết này không?')">
                                                                    <i class="fa fa-times"></i> 
                                                                </button>
                                                            </form>
                                                        @endif
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
            <div class="modal fade" id="violationDetailsModal{{ $violation['violation_id'] }}" tabindex="-1"
                aria-labelledby="violationDetailsModalLabel{{ $violation['violation_id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            @php
                                $reference_id = null;
                                $comment = null;
                            @endphp

                            {{-- Nếu là bài viết --}}
                            @if ($violation['type'] === 'article' && !empty($violation['article']))
                                @php $reference_id = $violation['article']['id']; @endphp
                                <h6>Bài Viết:</h6>
                                <p>
                                    <a href="{{ route('articles.article', $violation['article']['slug']) }}" target="_blank">
                                        {{ $violation['article']['title'] }}
                                    </a>

                                </p>

                                {{-- Nếu là bình luận --}}
                            @elseif ($violation['type'] === 'comment' && !empty($violation['comments']))
                                @php
                                    // Lấy bình luận trùng với reference_id
                                    $comment = $violation->comments->firstWhere(
                                        'comment_id',
                                        $violation['reference_id'],
                                    );
                                    $reference_id = $comment ? $comment->comment_id : null;
                                @endphp

                                @if ($comment)
                                    <div class="card mt-3">
                                        <div class="card-header bg-primary text-white">
                                            <strong>Bình luận vi phạm</strong>
                                        </div>
                                        <div class="card-body d-flex align-items-start">
                                            {{-- Avatar --}}
                                            <div style="width: 50px; height: 50px;"
                                                class="img img-cover icon-85 rounded-circle overflow-hidden flex-shrink-0 me-30">
                                                <img src="{{ asset('storage/' . ($comment->user->image ?? 'default-avatar.jpg')) }}"
                                                    alt="{{ $comment->user->username ?? 'Ẩn danh' }}"
                                                    onerror="this.onerror=null;this.src='https://th.bing.com/th/id/OIP.xyVi_Y3F3YwEIKzQm_j_jQHaHa?w=181&h=181&c=7&r=0&o=5&dpr=1.3&pid=1.7';">


                                            </div>

                                            <div>
                                                {{-- Tên người dùng --}}
                                                <p class="mb-1">
                                                    <strong>{{ $comment->user->username ?? 'Ẩn danh' }}</strong>
                                                </p>

                                                {{-- Nội dung bình luận --}}
                                                <p class="mb-0">{{ $comment->content }}</p>

                                                {{-- Liên kết đến bài viết --}}
                                                <p class="mt-2">
                                                    <a href="{{ route('articles.article', $comment->article->slug) }}"
                                                        target="_blank">
                                                        Xem bài viết
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mt-3">Không tìm thấy bình luận liên quan</div>
                                @endif
                            @else
                                <div class="alert alert-warning mt-3">Không có dữ liệu liên quan</div>
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
