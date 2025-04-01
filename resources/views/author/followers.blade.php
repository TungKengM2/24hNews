@extends('author.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Danh sách người theo dõi</h4>
                                <div class="box-controls pull-right">
                                    <a href="{{ route('author.dashboard') }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            </div>
                            <div class="box-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Ảnh</th>
                                                <th>Tên người dùng</th>
                                                <th>Email</th>
                                                <th>Theo dõi từ</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($followers as $follower)
                                                <tr>
                                                    <td>
                                                        <div class="avatar">
                                                            <img src="{{ $follower->image ? asset($follower->image) : asset('images/default-avatar.png') }}" 
                                                                alt="{{ $follower->username }}" 
                                                                class="rounded-circle"
                                                                style="width: 50px; height: 35px; object-fit: cover; border: 2px solid #eee;">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $follower->fullname ?? $follower->username }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ '@' . $follower->username }}</small>
                                                    </td>
                                                    <td>{{ $follower->email }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($follower->followed_at)->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('website.profileAuth', $follower->user_id) }}" 
                                                           class="btn btn-sm btn-info" 
                                                           target="_blank">
                                                            <i class="fa fa-user"></i> Xem hồ sơ
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Bạn chưa có người theo dõi nào</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ $followers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection 