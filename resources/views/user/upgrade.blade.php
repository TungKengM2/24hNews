@extends('user.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mt-40">
                <div class="card mt-50 mb-5">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Nâng cấp tài khoản thành Tác giả</h4>
                    </div>
                    <div class="card-body">
                        {{-- Hiển thị thông báo thành công/lỗi --}}
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('user.upgrade.request') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Thông tin cá nhân</h5>
                                        </div>
                                        <div class="card-body">
                                            {{-- Họ và tên --}}
                                            <div class="form-group mb-3">
                                                <label for="fullname">Họ và Tên <span class="text-danger">*</span></label>
                                                <input type="text" id="fullname" name="fullname" class="form-control"
                                                       value="{{ old('fullname', auth()->user()->fullname) }}" required>
                                                <small class="text-muted">Họ tên phải có ít nhất 5 ký tự, không chứa số và ký tự đặc biệt</small>
                                            </div>

                                            {{-- Ngày sinh --}}
                                            <div class="form-group mb-3">
                                                <label for="dob">Ngày sinh <span class="text-danger">*</span></label>
                                                <input type="date" id="dob" name="dob" class="form-control"
                                                       value="{{ old('dob', auth()->user()->dob) }}" required>
                                                <small class="text-muted">Tuổi phải từ đủ 18 đến 45 tuổi</small>
                                            </div>

                                            {{-- Số điện thoại --}}
                                            <div class="form-group mb-3">
                                                <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                                <input type="text" id="phone" name="phone" class="form-control"
                                                       value="{{ old('phone', auth()->user()->phone) }}" required>
                                                <small class="text-muted">Số điện thoại phải đúng định dạng Việt Nam</small>
                                            </div>

                                            {{-- Số CCCD --}}
                                            <div class="form-group mb-3">
                                                <label for="cccd_number">Số CCCD <span class="text-danger">*</span></label>
                                                <input type="text" id="cccd_number" name="cccd_number" class="form-control"
                                                       value="{{ old('cccd_number') }}" placeholder="Nhập số CCCD của bạn" required>
                                                <small class="text-muted">Số CCCD phải có 12 chữ số</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Địa chỉ</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="province">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                                <select class="form-control" id="province" name="province" required>
                                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="district">Quận/Huyện <span class="text-danger">*</span></label>
                                                <select class="form-control" id="district" name="district" required>
                                                    <option value="">Chọn Quận/Huyện</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="ward">Phường/Xã <span class="text-danger">*</span></label>
                                                <select class="form-control" id="ward" name="ward" required>
                                                    <option value="">Chọn Phường/Xã</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="address_detail">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                                                <input type="text" id="address_detail" name="address_detail" class="form-control"
                                                       placeholder="Số nhà, tên đường" required>
                                            </div>

                                            <input type="hidden" id="address" name="address">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Giấy tờ và chứng chỉ</h5>
                                </div>
                                <div class="card-body">
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

                                    <div class="form-group mb-3">
                                        <label for="certificates">Chứng chỉ hành nghề <span class="text-danger">*</span></label>
                                        <input type="file" id="certificates" name="certificates[]" class="form-control"
                                               accept="application/pdf" multiple required>
                                        <small class="text-muted">Chỉ chấp nhận file .PDF, kích thước tối đa 10MB</small>
                                        <div class="alert alert-info mt-2">
                                            <i class="ti-info-alt"></i> Lưu ý:
                                            <ul class="mb-0 mt-2">
                                                <li>Vui lòng tải lên các chứng chỉ liên quan đến lĩnh vực bạn muốn viết bài</li>
                                                <li>CCCD phải rõ ràng, không bị mờ, không bị khuất góc</li>
                                                <li>Chứng chỉ phải còn hiệu lực</li>
                                                <li>File PDF phải rõ ràng, không bị mờ</li>
                                                <li>Nếu có nhiều chứng chỉ, vui lòng tải lên tất cả</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Nút gửi yêu cầu --}}
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Gửi yêu cầu nâng cấp</button>
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

        // Real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy form và các input cần validate
            const form = document.querySelector('form');
            const fullnameInput = document.getElementById('fullname');
            const dobInput = document.getElementById('dob');
            const phoneInput = document.getElementById('phone');
            const cccdInput = document.getElementById('cccd_number');
            const provinceSelect = document.getElementById('province');
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward');
            const addressDetailInput = document.getElementById('address_detail');
            const addressInput = document.getElementById('address');

            // Hàm hiển thị lỗi
            function showError(input, message) {
                const formGroup = input.closest('.form-group');
                let errorDiv = formGroup.querySelector('.error-message');

                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message text-danger mt-1';
                    formGroup.appendChild(errorDiv);
                }

                errorDiv.textContent = message;
                input.classList.add('is-invalid');
                input.style.borderColor = '#dc3545';
            }

            // Hàm xóa lỗi
            function removeError(input) {
                const formGroup = input.closest('.form-group');
                const errorDiv = formGroup.querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.remove();
                }
                input.classList.remove('is-invalid');
                input.style.borderColor = '';
            }

            // Validate họ tên
            function validateFullname() {
                const value = fullnameInput.value.trim();
                removeError(fullnameInput);

                if (!value) {
                    showError(fullnameInput, 'Họ tên là bắt buộc');
                    return false;
                }

                const nameRegex = /^[a-zA-ZÀ-ỹ\s]{5,}$/;
                if (!nameRegex.test(value)) {
                    showError(fullnameInput, 'Họ tên phải có ít nhất 5 ký tự, không chứa số và ký tự đặc biệt');
                    return false;
                }

                return true;
            }

            // Validate ngày sinh
            function validateDob() {
                const value = dobInput.value;
                removeError(dobInput);

                if (!value) {
                    showError(dobInput, 'Ngày sinh là bắt buộc');
                    return false;
                }

                const today = new Date();
                const birthDate = new Date(value);
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                if (age < 18) {
                    showError(dobInput, 'Bạn phải đủ 18 tuổi trở lên');
                    return false;
                }

                if (age > 45) {
                    showError(dobInput, 'Tuổi của bạn không được vượt quá 45');
                    return false;
                }

                return true;
            }

            // Validate số điện thoại
            function validatePhone() {
                const value = phoneInput.value.trim();
                removeError(phoneInput);

                if (!value) {
                    showError(phoneInput, 'Số điện thoại là bắt buộc');
                    return false;
                }

                const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
                if (!phoneRegex.test(value)) {
                    showError(phoneInput, 'Số điện thoại không hợp lệ');
                    return false;
                }

                return true;
            }

            // Validate số CCCD
            function validateCCCD() {
                const value = cccdInput.value.trim();
                removeError(cccdInput);

                if (!value) {
                    showError(cccdInput, 'Số CCCD là bắt buộc');
                    return false;
                }

                const cccdRegex = /^[0-9]{12}$/;
                if (!cccdRegex.test(value)) {
                    showError(cccdInput, 'Số CCCD phải có 12 chữ số');
                    return false;
                }

                return true;
            }

            // Validate địa chỉ
            function validateAddress() {
                let isValid = true;

                // Validate tỉnh/thành phố
                if (!provinceSelect.value) {
                    showError(provinceSelect, 'Vui lòng chọn Tỉnh/Thành phố');
                    isValid = false;
                } else {
                    removeError(provinceSelect);
                }

                // Validate quận/huyện
                if (!districtSelect.value) {
                    showError(districtSelect, 'Vui lòng chọn Quận/Huyện');
                    isValid = false;
                } else {
                    removeError(districtSelect);
                }

                // Validate phường/xã
                if (!wardSelect.value) {
                    showError(wardSelect, 'Vui lòng chọn Phường/Xã');
                    isValid = false;
                } else {
                    removeError(wardSelect);
                }

                // Validate địa chỉ chi tiết
                if (!addressDetailInput.value.trim()) {
                    showError(addressDetailInput, 'Vui lòng nhập địa chỉ chi tiết');
                    isValid = false;
                } else {
                    removeError(addressDetailInput);
                }

                return isValid;
            }

            // Thêm sự kiện cho từng input
            fullnameInput.addEventListener('input', validateFullname);
            fullnameInput.addEventListener('blur', validateFullname);

            dobInput.addEventListener('input', validateDob);
            dobInput.addEventListener('blur', validateDob);

            phoneInput.addEventListener('input', validatePhone);
            phoneInput.addEventListener('blur', validatePhone);

            cccdInput.addEventListener('input', validateCCCD);
            cccdInput.addEventListener('blur', validateCCCD);

            provinceSelect.addEventListener('change', validateAddress);
            districtSelect.addEventListener('change', validateAddress);
            wardSelect.addEventListener('change', validateAddress);
            addressDetailInput.addEventListener('input', validateAddress);
            addressDetailInput.addEventListener('blur', validateAddress);

            // Validate form trước khi submit
            form.addEventListener('submit', function(e) {
                const isFullnameValid = validateFullname();
                const isDobValid = validateDob();
                const isPhoneValid = validatePhone();
                const isCCCDValid = validateCCCD();
                const isAddressValid = validateAddress();

                if (!isFullnameValid || !isDobValid || !isPhoneValid || !isCCCDValid || !isAddressValid) {
                    e.preventDefault();
                }
            });

            // Xử lý địa chỉ
            // Hàm cập nhật địa chỉ đầy đủ
            function updateFullAddress() {
                const province = provinceSelect.options[provinceSelect.selectedIndex].text;
                const district = districtSelect.options[districtSelect.selectedIndex].text;
                const ward = wardSelect.options[wardSelect.selectedIndex].text;
                const detail = addressDetailInput.value;

                if (province && district && ward && detail) {
                    addressInput.value = `${detail}, ${ward}, ${district}, ${province}`;
                }
            }

            // Lắng nghe sự kiện thay đổi địa chỉ
            [provinceSelect, districtSelect, wardSelect, addressDetailInput].forEach(element => {
                element.addEventListener('change', updateFullAddress);
                element.addEventListener('input', updateFullAddress);
            });

            // Load danh sách tỉnh/thành phố
            fetch('https://provinces.open-api.vn/api/p/')
                .then(response => response.json())
                .then(data => {
                    data.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.code;
                        option.textContent = province.name;
                        provinceSelect.appendChild(option);
                    });
                });

            // Load danh sách quận/huyện khi chọn tỉnh/thành phố
            provinceSelect.addEventListener('change', function() {
                districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

                if (this.value) {
                    fetch(`https://provinces.open-api.vn/api/p/${this.value}?depth=2`)
                        .then(response => response.json())
                        .then(data => {
                            data.districts.forEach(district => {
                                const option = document.createElement('option');
                                option.value = district.code;
                                option.textContent = district.name;
                                districtSelect.appendChild(option);
                            });
                        });
                }
            });

            // Load danh sách phường/xã khi chọn quận/huyện
            districtSelect.addEventListener('change', function() {
                wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

                if (this.value) {
                    fetch(`https://provinces.open-api.vn/api/d/${this.value}?depth=2`)
                        .then(response => response.json())
                        .then(data => {
                            data.wards.forEach(ward => {
                                const option = document.createElement('option');
                                option.value = ward.code;
                                option.textContent = ward.name;
                                wardSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
@endsection
