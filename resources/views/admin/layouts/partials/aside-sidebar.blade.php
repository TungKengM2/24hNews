@php
    // Đếm số bài viết đang chờ duyệt
    $pendingArticlesCount = \App\Models\Article::where('status', 'pending')->count();

    // Đếm số vi phạm chờ xử lý
    $pendingViolations = \App\Models\Violation::where('status', 'pending')->count();

    // Đếm số yêu cầu nâng cấp tài khoản chưa được xử lý
    $pendingRoleRequestsCount = \App\Models\Approval::where('type', 'role_upgrade')
        ->where('status', 'pending')
        ->count();

    // Đếm số yêu cầu chỉnh sửa đang chờ duyệt
    $pendingEditRequestsCount = \App\Models\EditRequest::where('status', 'pending')->count();

    // Tính tổng số thông báo
    $totalPendingCount = $pendingArticlesCount + $pendingViolations + $pendingRoleRequestsCount + $pendingEditRequestsCount;
@endphp

<section class="sidebar position-relative">
    <div class="multinav">
        <div class="multinav-scroll" style="height: 100%;">
            <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="">
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="monitor"></i>
                        <span>Dashboard</span>
                        {{-- <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span> --}}
                    </a>
                    {{-- <ul class="treeview-menu">
                        <li><a href="index.html"><i class="icon-Commit"><span class="path1"></span><span
                                        class="path2"></span></i>Analytics</a></li>
                        <li><a href="index-2.html"><i class="icon-Commit"><span class="path1"></span><span
                                        class="path2"></span></i>e-Commerce</a></li>
                    </ul> --}}
                </li>
                <li class="header">Quản Lý</li>
                <li class="treeview">
                    <a href="index.html#">
                        <i data-feather="grid"></i>
                        <span>Bài Viết & Danh Mục</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('articles.index') }}"><i class="icon-Commit">
                                    <span class="path1"></span><span class="path2"></span></i>Bài Viết</a>
                        </li>

                        <li>
                            <a href="{{ route('categories.index') }}"><i class="icon-Commit">
                                    <span class="path1"></span><span class="path2"></span></i>Danh Mục
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.users.index') }}"><i class="icon-Commit">
                                    <span class="path1"></span><span class="path2"></span></i>Người Dùng
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('tags.index') }}"><i class="icon-Commit">
                                    <span class="path1"></span><span class="path2"></span></i>Thẻ
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="treeview">
                    <a href="index.html#">
                        <i data-feather="grid"></i>
                        <span>Kiểm Duyệt</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        @if($totalPendingCount > 0)
                            <x-notification-badge :count="$totalPendingCount" />
                        @endif
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('admin.articles.approves') }}" style="position: relative;">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Duyệt Bài Viết
                                @if($pendingArticlesCount > 0)
                                    <x-notification-badge :count="$pendingArticlesCount" />
                                @endif
                        </li>
                        {{-- <li><a href="{{ route('admin.comments.index') }}"><i class="icon-Commit"><span
                                        class="path1"></span><span class="path2"></span></i>Quản Lý Bình Luận</a>
                        </li> --}}
{{--                        <li>--}}
{{--                            <a href="{{ route('admin.edit-requests.index') }}" style="position: relative;">--}}
{{--                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>--}}
{{--                                Duyệt Yêu Cầu Chỉnh Sửa--}}
{{--                                @if($pendingEditRequestsCount > 0)--}}
{{--                                    <x-notification-badge :count="$pendingEditRequestsCount" />--}}
{{--                                @endif--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        {{-- <li><a href="{{ route('admin.violations.approves') }}"><i class="icon-Commit"><span
                                        class="path1"></span><span class="path2"></span></i>Duyệt Report</a>
                        </li> --}}
                        <li><a href="{{ route('admin.moderation.history') }}"><i class="icon-Commit"><span
                                        class="path1"></span><span class="path2"></span></i>Lịch sử kiểm duyệt</a>
                        </li>
                        {{-- <li><a href="{{ route('admin.user-role-requests') }}"><i class="icon-Commit"><span
                                        class="path1"></span><span class="path2"></span></i>Nâng Cấp Tài Khoản
                            </a>
                        </li> --}}
                        <li>
                            <a href="{{ route('admin.violations.approves') }}" style="position: relative;">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Duyệt Report
                                @if($pendingViolations > 0)
                                    <x-notification-badge :count="$pendingViolations" />
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.user-role-requests') }}" style="position: relative;">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Nâng Cấp Tài Khoản
                                @if($pendingRoleRequestsCount > 0)
                                    <x-notification-badge :count="$pendingRoleRequestsCount" />
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i data-feather="grid"></i>
                        <span>Hoạt Động</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('admin.comments', ['user_id' => Auth::id()]) }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Hoạt Động Bình Luận
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.saved') }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Tin Đã Lưu
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.viewed.articles') }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Tin Đã Xem
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.following') }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Người Đã Theo Dõi
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</section>
