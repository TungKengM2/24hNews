@extends('user.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Nâng cấp tài khoản thành Tác giả</h4>
                    </div>
                    <div class="card-body">
                        {{-- Hiển thị lỗi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Hiển thị thông báo thành công/lỗi --}}
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('user.upgrade.author') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Họ và tên --}}
                            <div class="form-group mb-3">
                                <label for="full_name">Họ và Tên <span class="text-danger">*</span></label>
                                <input type="text" id="full_name" name="full_name" class="form-control"
                                       value="{{ old('full_name', auth()->user()->fullname) }}" required>
                            </div>

                            {{-- Ngày sinh --}}
                            <div class="form-group mb-3">
                                <label for="dob">Ngày sinh <span class="text-danger">*</span></label>
                                <input type="date" id="dob" name="dob" class="form-control"
                                       value="{{ old('dob', auth()->user()->dob) }}" required>
                            </div>

                            {{-- Địa chỉ --}}
                            <div class="form-group mb-3">
                                <label for="address">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" id="address" name="address" class="form-control"
                                       value="{{ old('address', auth()->user()->address) }}" required>
                            </div>

                            {{-- Số điện thoại --}}
                            <div class="form-group mb-3">
                                <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                       value="{{ old('phone', auth()->user()->phone) }}" required>
                            </div>

                            {{-- Số CCCD --}}
                            <div class="form-group mb-3">
                                <label for="cccd_number">Số CCCD <span class="text-danger">*</span></label>
                                <input type="text" id="cccd_number" name="cccd_number" class="form-control"
                                       value="{{ old('cccd_number') }}" placeholder="Nhập số CCCD của bạn" required>
                            </div>

                            {{-- Ảnh CCCD --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cccd_front">Ảnh CCCD mặt trước <span class="text-danger">*</span></label>
                                        <input type="file" id="cccd_front" name="cccd_front" class="form-control"
                                               accept="image/*" required onchange="previewImage(event, 'preview_front')">
                                        <img id="preview_front" src="#" alt="Xem trước ảnh mặt trước"
                                             class="img-fluid mt-2 d-none" style="max-width: 100%; height: auto;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cccd_back">Ảnh CCCD mặt sau <span class="text-danger">*</span></label>
                                        <input type="file" id="cccd_back" name="cccd_back" class="form-control"
                                               accept="image/*" required onchange="previewImage(event, 'preview_back')">
                                        <img id="preview_back" src="#" alt="Xem trước ảnh mặt sau"
                                             class="img-fluid mt-2 d-none" style="max-width: 100%; height: auto;">
                                    </div>
                                </div>
                            </div>

                            {{-- Lý do nâng cấp --}}
                            <div class="form-group mb-3">
                                <label for="reason">Lý do yêu cầu nâng cấp <span class="text-danger">*</span></label>
                                <textarea id="reason" name="reason" class="form-control" rows="4"
                                          placeholder="Nhập lý do bạn muốn trở thành tác giả" required>{{ old('reason') }}</textarea>
                            </div>

                            {{-- Nút gửi yêu cầu --}}
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Gửi yêu cầu nâng cấp</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script xem trước ảnh CCCD --}}
    <script>
        function previewImage(event, previewId) {
            let input = event.target;
            let reader = new FileReader();
            let preview = document.getElementById(previewId);

            reader.onload = function () {
                preview.src = reader.result;
                preview.classList.remove('d-none');
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
