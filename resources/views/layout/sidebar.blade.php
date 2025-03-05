<div class="sidebar">
    <div class="profile">
        <div class="avatar-wrapper">
            <img id="avatarPreview"
                src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                alt="Avatar">

            <label for="avatarUpload" class="avatar-edit">
                <i class="fa-solid fa-camera"></i>
            </label>
            <input type="file" id="avatarUpload" name="image" accept="image/*" style="display: none;">
        </div>
        <h3>{{ Auth::user()->username }}</h3>
    </div>



    <ul class="menu">
        <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
            <a href="{{ route('profile') }}">
                <i class="fa-solid fa-user"></i>
                <span>Thông tin tài khoản</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('profile.change-password') ? 'active' : '' }}">
            <a href="{{ route('profile.change-password') }}">
                <i class="fa-solid fa-lock"></i>
                <span>Đổi mật khẩu</span>
            </a>
        </li>

        <li>
            <a href="#"> {{-- Thêm link vào nếu có trang hoạt động bình luận --}}
                <i class="fa-solid fa-comment"></i>
                <span>Hoạt động bình luận</span>
            </a>
        </li>

        <li>
            <a href="#"> {{-- Thêm link vào nếu có trang tin đã lưu --}}
                <i class="fa-solid fa-bookmark"></i>
                <span>Tin đã lưu</span>
            </a>
        </li>

        <li>
            <a href="#"> {{-- Thêm link vào nếu có trang tin đã xem --}}
                <i class="fa-solid fa-eye"></i>
                <span>Tin đã xem</span>
            </a>
        </li>

        <li class="logout">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-sign-out-alt"></i>
                <span>Đăng xuất</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
