<aside class="sidebar">
    <h2>Author Panel</h2>
    <ul>
        <li><a href="{{ route('author.dashboard') }}"
               class="{{ request()->routeIs('author.dashboard') ? 'active' : '' }}">Thống kê</a></li>
        <li><a href="{{ route('author.articles') }}"
               class="{{ request()->routeIs('author.articles') ? 'active' : '' }}">Quản
                lý bài viết</a></li>
        <li><a href="{{ route('author.profile') }}" class="{{ request()->routeIs('author.profile') ? 'active' : '' }}">Hồ
                sơ cá nhân</a></li>
    </ul>
</aside>
