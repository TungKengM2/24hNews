@extends('user.layouts.master')

@section('title')
    Thống tin tài khoản
@endsection

@section('content')
    <div class="card p-4">

        <div class="">
            <div class="container-full">
                <section class="content">

                    <div class="row">
                        <div class="user-profile">
                            <div class="box box-widget widget-user">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-img bbsr-0 bber-0"
                                    style="background: url('../images/gallery/full/10.jpg') center center;" data-overlay="5">
                                    <h3 class="widget-user-username text-white">Username</h3>
                                    <h6 class="widget-user-desc text-white">{{ $user->username }}</h6>
                                </div>
                                <div class="widget-user-image">
                                    <img class="rounded-circle"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                                        alt="Avatar">
                                    <label for="avatarUpload" class="avatar-edit">
                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" id="avatarUpload" name="image" accept="image/*"
                                        style="display: none;">
                                </div>
                                <h3>{{ Auth::user()->username }}</h3>
                            </div>
                            <div class="box-footer">
                            </div>
                        </div>
                        <h4>Thông tin tài khoản</h4>

                        {{-- Thông báo thành công hoặc thất bại --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf

                            {{-- Tên hiển thị --}}
                            <div class="mb-3">
                                <label class="form-label">Tên hiển thị</label>
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username', auth()->user()->username) }}" required>
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email (Không cho sửa) --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                            </div>

                            {{-- Điện thoại --}}
                            <div class="mb-3">
                                <label class="form-label">Điện thoại</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', auth()->user()->phone) }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nút lưu --}}
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>

            </div>
            <!-- /.row -->

            </section>
            <!-- /.content -->
        </div>
    </div>

    {{-- Thông báo thành công hoặc thất bại --}}
    </div>
@endsection
