<section class="sidebar position-relative">
    <div class="multinav">
        <div class="multinav-scroll" style="height: 100%;">
            <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">

                <li class="header">Quản Lý</li>

                <li class="treeview">
                    <a href="index.html#">
                        <i data-feather="grid"></i>
                        <span>Kiểm Duyệt</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('moderator.articles.index') }}"><i class="icon-Commit"><span
                                        class="path1"></span><span class="path2"></span></i>Bài Viết</a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="{{ route('moderator.articles.index') }}">
                        <i data-feather="grid"></i>
                        <span>Hoạt Động</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('moderator.comments', ['user_id' => Auth::id()]) }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Hoạt Động Bình Luận
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('moderator.saved') }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Tin Đã Lưu
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('moderator.viewed.articles') }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Tin Đã Xem
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('moderator.following') }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Người Đã Theo Dõi
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="sidebar-widgets">
                <div class="copyright text-start m-25">
                    <p><strong class="d-block">Kiểm Duyệt Viên Dashboard</strong> © 2025 All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
</section>
