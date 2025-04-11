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
                            <div class="info mt-20">
                                <div class="description mt-20">
                                    <p class="color-666 mb-20"> {{ $user->description ?? 'Không Có Mô Tả Trang Cá Nhân' }}
                                    </p>
                                    {{-- dat them hiển thị bài viết đã xem --}}
                                    <div class="content">
                                        <h4>Đổi mật khẩu</h4>
                    
                                        <div class="pane" id="settings">
                    
                                            <div class="box no-shadow">
                                                <form action="{{ route('profile.update-password') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="current_password">Mật khẩu hiện tại</label>
                                                        <input type="password" id="current_password" name="current_password"
                                                            class="form-control" required>
                                                        @error('current_password')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                    
                                                    <div class="form-group">
                                                        <label for="new_password">Mật khẩu mới</label>
                                                        <input type="password" id="new_password" name="new_password" class="form-control"
                                                            required>
                                                        @error('new_password')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                    
                                                    <div class="form-group">
                                                        <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                                            class="form-control" required>
                                                        @error('new_password_confirmation')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                    
                                                    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                                                </form>
                    
                                                @if (session('success'))
                                                    <div class="alert alert-success mt-3">
                                                        {{ session('success') }}
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
