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
                            <p class="color-666 mb-20"> {{ $user->description ?? 'Không Có Mô Tả Trang Cá Nhân' }} </p>
                            <div class="info mt-20">
                                <div class="description mt-20 pt-4">
                                    {{-- dat them hiển thị bài viết đã xem --}}
<div class="content pt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Đổi mật khẩu</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update-password') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                    <div class="input-group">
                        <input type="password" id="current_password" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror" required>
                        <span class="input-group-text toggle-password" data-target="current_password">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <div class="input-group">
                        <input type="password" id="new_password" name="new_password" 
                            class="form-control @error('new_password') is-invalid @enderror" required>
                        <span class="input-group-text toggle-password" data-target="new_password">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                    <div class="input-group">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="form-control @error('new_password_confirmation') is-invalid @enderror" required>
                        <span class="input-group-text toggle-password" data-target="new_password_confirmation">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('new_password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cập nhật mật khẩu
                    </button>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
        </section>
    </main>
@endsection
