@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start author header ====== -->
        <section class="tc-author-header">
            <div class="container">
                <div class="content">
                    <div class="title">
                        @if ($user->role)
                            <p class="fsz-14px color-fff op-5 mb-2">{{ ucfirst($user->role->name) }}</p>
                        @endif
                        <h2> {{ $user->username }} </h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author header ====== -->
        


        <!-- ====== start author-details ====== -->
        <section class="tc-author-details">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="">
                        <div class="content">
                            <div class="author-img img-cover">
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
                            </div>
                            <p class="color-666 mb-20"> {{ $user->description ?? 'Không Có Mô Tả Trang Cá Nhân' }}
                            </p>
                            <div class="info mt-20">
                                <div class="description mt-20">
                                    {{-- dat them hiển thị bài viết đã xem --}}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
