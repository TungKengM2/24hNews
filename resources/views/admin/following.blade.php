@extends('admin.layouts.master')

@section('title')
    Danh sách người đã theo Dõi
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <h4 class="page-title">Danh sách những người bạn đang theo dõi</h4>

            <div class="table-responsive">
                @if ($followingUsers->isEmpty())
                    <p>Bạn chưa theo dõi ai.</p>
                @else
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh đại diện</th>
                                <th>Tên người dùng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($followingUsers as $index => $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($followingUsers->currentPage() - 1) * $followingUsers->perPage() }}
                                    </td>
                                    <td>
                                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/default-avatar.png') }}"
                                            alt="{{ $user->username }}" width="50" height="50">
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('website.profileAuth', ['id' => $user->user_id]) }}">{{ $user->username }}</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.unfollow', $user->user_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Hủy Follow</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-end mt-3">
                {{ $followingUsers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
