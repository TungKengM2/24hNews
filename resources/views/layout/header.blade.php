<header class="bg-primary text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h3>Website Tin Tức</h3>
        <nav>
            <a href="/">Trang chủ</a>
            @auth
                <a href="{{ route('profile') }}">Profile</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
        </nav>
    </div>
</header>
