<section class="sidebar position-relative">
    <div class="multinav">
        <div class="multinav-scroll" style="height: 100%;">
            <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">
                {{-- <li class="treeview">
                    <a href="index.html#">
                        <i data-feather="monitor"></i>
                        <span>Dashboard</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="index.html"><i class="icon-Commit"><span class="path1"></span><span
                                        class="path2"></span></i>Analytics</a></li>
                        <li><a href="index-2.html"><i class="icon-Commit"><span class="path1"></span><span
                                        class="path2"></span></i>e-Commerce</a></li>
                    </ul>
                </li> --}}
                <li class="header">Quản Lý</li>
                <li class="treeview">
                    {{-- <a href="index.html#">
                        <i data-feather="grid"></i>
                        <span>Bài Viết Đã Lưu</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a> --}}
                    {{-- <ul class="treeview-menu"> --}}
                <li class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}">
                        <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                        Thông Tin Tài Khoản
                    </a>
                </li>
                <li class="{{ request()->routeIs('user.change-password') ? 'active' : '' }}">
                    <a href="{{ route('user.change-password') }}">
                        <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                        Đổi Mật Khẩu
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                        Hoạt Động Bình Luận
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                        Tin Đã Lưu
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                        Tin Đã Xem
                    </a>
                </li>
                {{-- </ul> --}}
                </li>
            </ul>

            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"><a href="http://24hnews.test/">Quay Lại Trang Chủ</a></li>
                <li class="treeview">
            </ul>

            {{-- <ul class="sidebar-menu" data-widget="tree">
                <li class="header">
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-sign-out-alt"></i>
                        <span>Đăng xuất</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul> --}}



            <div class="sidebar-widgets">
                <div class="copyright text-start m-25">
                    <p><strong class="d-block">User</strong> © 2025 All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
</section>
