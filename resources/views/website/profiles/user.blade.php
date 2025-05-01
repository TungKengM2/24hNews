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
                            <div class="author-img">
                                <div class="widget-user-image">
                                    <img id="avatarPreview" class="rounded-circle"
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

                                    <style>
                                        .author-img {
                                            display: flex;
                                            justify-content: center;
                                            margin-bottom: 20px;
                                        }
                                        .widget-user-image {
                                            position: relative;
                                            width: 150px;
                                            height: 150px;
                                            cursor: pointer;
                                            border-radius: 50%;
                                            overflow: hidden;
                                        }
                                        .widget-user-image img {
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                            border-radius: 50%;
                                        }
                                        .avatar-edit {
                                            position: absolute;
                                            bottom: 0;
                                            right: 0;
                                            background: rgba(0, 0, 0, 0.5);
                                            width: 40px;
                                            height: 40px;
                                            border-radius: 50%;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            color: white;
                                            cursor: pointer;
                                            transition: all 0.3s ease;
                                            z-index: 1;
                                        }
                                        .avatar-edit:hover {
                                            background: rgba(0, 0, 0, 0.7);
                                        }
                                        .avatar-edit i {
                                            font-size: 20px;
                                        }
                                    </style>

                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const toggle = document.querySelector('.edit-profile-toggle');
                                        const form = document.querySelector('.profile-form');
                                        const chevron = toggle.querySelector('.fa-chevron-down');
                                        const avatarInput = document.getElementById('avatarUpload');
                                        const avatarPreview = document.getElementById('avatarPreview');
                                        const widgetUserImage = document.querySelector('.widget-user-image');
                                    
                                        // Toggle profile form
                                        toggle.addEventListener('click', function() {
                                            form.style.display = form.style.display === 'none' ? 'block' : 'none';
                                            chevron.style.transform = form.style.display === 'none' ? 'rotate(0deg)' : 'rotate(180deg)';
                                        });
                                    
                                        // Hide form on successful submission
                                        if (document.querySelector('.alert-success')) {
                                            form.style.display = 'none';
                                            chevron.style.transform = 'rotate(0deg)';
                                        }
                                    
                                        // Handle avatar upload
                                        widgetUserImage.addEventListener('click', function() {
                                            avatarInput.click();
                                        });
                                    
                                        avatarInput.addEventListener('change', function() {
                                            if (this.files && this.files[0]) {
                                                const formData = new FormData();
                                                formData.append('image', this.files[0]);
                                                formData.append('_token', '{{ csrf_token() }}');
                                    
                                                // Show loading state
                                                avatarPreview.style.opacity = '0.5';
                                    
                                                fetch('{{ route("profile.upload-avatar") }}', {
                                                    method: 'POST',
                                                    body: formData
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    console.log(data); // Debugging the response
                                    
                                                    if (data.success) {
                                                        avatarPreview.src = data.avatar_url; // Update the avatar with the new URL
                                                    } else {
                                                        throw new Error(data.message || 'Có lỗi xảy ra');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Lỗi:', error); // Debugging the actual error
                                                    const alertDiv = document.createElement('div');
                                                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                                                    alertDiv.innerHTML = `
                                                        ${error.message || 'Đã xảy ra lỗi. Vui lòng thử lại sau.'}  <!-- Updated error message in Vietnamese -->
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    `;
                                                    document.querySelector('.box-body').insertBefore(alertDiv, document.querySelector('.edit-profile-toggle'));
                                                })
                                                .finally(() => {
                                                    // Reset loading state
                                                    avatarPreview.style.opacity = '1';
                                                });
                                            }
                                        });
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

@push('scripts')
@endpush
