@extends('admin.layouts.master')

@section('title')
    Danh sách người theo dõi
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <h4 class="page-title">Danh sách người theo dõi bạn</h4>

            <div class="table-responsive">
                @if ($followers->isEmpty())
                    <p>Bạn chưa có người theo dõi nào.</p>
                @else
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh đại diện</th>
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Theo dõi từ</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($followers as $index => $follower)
                                <tr>
                                    <td>{{ $loop->iteration + ($followers->currentPage() - 1) * $followers->perPage() }}</td>
                                    <td>
                                        <img src="{{ $follower->image ? asset('storage/' . $follower->image) : asset('images/default-avatar.png') }}"
                                            alt="{{ $follower->username }}" width="50" height="50" class="rounded-circle">
                                    </td>
                                    <td>
                                        <strong>{{ $follower->fullname ?? $follower->username }}</strong>
                                        <br>
                                        <small class="text-muted">{{ '@' . $follower->username }}</small>
                                    </td>
                                    <td>{{ $follower->email }}</td>
                                    <td>{{ \Carbon\Carbon::parse($follower->followed_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="{{ route('website.profileAuth', ['id' => $follower->user_id]) }}" 
                                               class="btn btn-info btn-sm mb-2">
                                                <i class="fa fa-user"></i> Xem hồ sơ
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-end mt-3">
                {{ $followers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
