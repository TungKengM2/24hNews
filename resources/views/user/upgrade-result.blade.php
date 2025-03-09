@extends('user.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    @if(session('status'))
                        <div class="card-header bg-success text-white text-center">
                            Thông báo thành công
                        </div>
                        <div class="card-body text-center">
                            <p>{{ session('status') }}</p>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Quay lại trang chủ</a>
                        </div>
                    @elseif(session('error'))
                        <div class="card-header bg-danger text-white text-center">
                            Thông báo lỗi
                        </div>
                        <div class="card-body text-center">
                            <p>{{ session('error') }}</p>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Quay lại chỉnh sửa hồ sơ</a>
                        </div>
                    @else
                        <div class="card-header text-center">
                            Thông tin tài khoản
                        </div>
                        <div class="card-body">
                            {{-- Nội dung trang profile.edit mặc định --}}
                            <p>Đây là trang chỉnh sửa thông tin cá nhân của bạn.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
