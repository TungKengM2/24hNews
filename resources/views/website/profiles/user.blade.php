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
                            <div class="row">
                                <p class="color-666 mb-20"> {{ $user->description ?? 'Không Có Mô Tả Trang Cá Nhân' }}
                            </div>
                            <div class="info">
                                <div class="description mt-20">
                                    
                                    </p>
                                    {{-- dat them thông tin tài khoản --}}
                                    <div class="box w-100">
                                        <div class="box-body box-profile p-4 bg-white rounded shadow-sm">
                                            <h4 class="mb-4 border-bottom pb-3 edit-profile-toggle" style="cursor: pointer">
                                                hãy nhấn để xem và sửa thông tin tài khoản
                                                <i class="fas fa-chevron-down float-end"></i>
                                            </h4>
        
                                            @if (session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif
        
                                            @if (session('error'))
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    {{ session('error') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif
        
                                            <form action="{{ route('profile.update') }}" method="POST" class="needs-validation profile-form" style="display: none;">
                                                @csrf
        
                                                <div class="mb-4">
                                                    <label class="form-label fw-medium">Tên hiển thị</label>
                                                    <input type="text" name="username"
                                                        class="form-control form-control-lg @error('username') is-invalid @enderror"
                                                        value="{{ old('username', auth()->user()->username) }}" 
                                                        required>
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-medium">Mô Tả Trang Cá Nhân</label>
                                                    <textarea name="description" 
                                                        class="form-control form-control-lg @error('description') is-invalid @enderror" 
                                                        rows="3"
                                                        required>{{ old('description', auth()->user()->description) }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-medium">Email</label>
                                                    <input type="email" 
                                                        class="form-control form-control-lg bg-light" 
                                                        value="{{ auth()->user()->email }}"
                                                        disabled>
                                                </div>
        
                                                <div class="mb-4">
                                                    <label class="form-label fw-medium">Điện thoại</label>
                                                    <input type="text" name="phone"
                                                        class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                                        value="{{ old('phone', auth()->user()->phone) }}">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
        
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const toggle = document.querySelector('.edit-profile-toggle');
                                            const form = document.querySelector('.profile-form');
                                            const chevron = toggle.querySelector('.fa-chevron-down');

                                            toggle.addEventListener('click', function() {
                                                form.style.display = form.style.display === 'none' ? 'block' : 'none';
                                                chevron.style.transform = form.style.display === 'none' ? 'rotate(0deg)' : 'rotate(180deg)';
                                            });

                                            // Hide form on successful submission
                                            if (document.querySelector('.alert-success')) {
                                                form.style.display = 'none';
                                                chevron.style.transform = 'rotate(0deg)';
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
