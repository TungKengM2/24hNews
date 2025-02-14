<aside id="sidebar">
            <div class="d-flex">
                <div class="sidebar-logo">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Logo 24H News">
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Người dùng</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('articles.index') }}" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Article</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('categories.index') }}" class="sidebar-link">
                        <i class="lni lni-list"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown">
                        <i class="lni lni-protection"></i>
                        <span>Chức Năng </span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Chức Năng 1</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Chức Năng 2</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown">
                        <i class="lni lni-layout"></i>
                        <span>Liên Kết</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Liên kết 1</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Liên kết 2</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Thông báo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Cài đặt</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </aside>
