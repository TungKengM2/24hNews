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
                    <div class="col-lg-5">
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
                            <div class="info">
                                <div class="description mt-20">
                                    <p class="color-666 mb-20"> {{ $user->description ?? 'Không Có Mô Tả Trang Cá Nhân' }}
                                    </p>
                                    {{-- dat them thông tin tài khoản --}}
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
