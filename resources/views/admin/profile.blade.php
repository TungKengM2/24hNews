@extends('admin.layouts.master')

@section('title')
    Thông Tin Cá Nhân
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/profile-avatar.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="row">
                    <div class="user-profile">
                        <div class="box box-widget widget-user">
                            <div class="widget-user-header bg-img bbsr-0 bber-0 justify-content-center align-items-center h-175 pl-[25px] flex-block  "
                                style="background: url('/admin/images/gallery/full/10.jpg') center center;" data-overlay="5">
                                <h1 class="widget-user-username text-white" style="margin-right: 50px">{{ $user->username }}</h1>
                                <h4 class="widget-user-desc text-white mt-2" style="margin-right: 50px">{{ $user->description ?? 'Chưa có mô tả' }}</h4>
                            </div>
                            <div class="author-img">
                                <div class="widget-user-image">
                                    <img id="avatarPreview" class="rounded-circle"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                                        alt="Avatar">
                                    <label for="avatarUpload" class="avatar-edit">
                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" id="avatarUpload" name="image" accept="image/*" style="display: none;">
                                </div>
                            </div>
                            <div class="box-footer ">
                                <!-- Các nội dung khác -->
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-body box-profile">
                                <h4>Thông tin tài khoản</h4>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Tên hiển thị</label>
                                        <input type="text" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username', auth()->user()->username) }}" required>
                                        @error('username')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mô Tả Trang Cá Nhân</label>
                                        <input type="text" name="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            value="{{ old('description', auth()->user()->description) }}" required>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}"
                                            disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Điện thoại</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', auth()->user()->phone) }}">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
