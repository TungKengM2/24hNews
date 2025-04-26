@php
    // Đếm số bài viết đang chờ duyệt trong các danh mục của moderator
    $moderatorCategories = auth()->user()->categories()->pluck('category_id')->toArray();
    $pendingArticlesCount = \App\Models\Article::whereIn('category_id', $moderatorCategories)
        ->where('status', 'pending')
        ->count();

    // Đếm số report chưa được xử lý trong các danh mục của moderator
    $pendingViolationsCount = \App\Models\Violation::whereHas('article', function ($query) use ($moderatorCategories) {
        $query->whereIn('category_id', $moderatorCategories);
    })
        ->where('status', 'pending')
        ->count();

    // Đếm số vi phạm chờ xử lý
    $pendingViolations = \App\Models\Violation::where('status', 'pending')->count();
@endphp

<section class="sidebar position-relative">
    <div class="multinav">
        <div class="multinav-scroll" style="height: 100%;">
            <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">

                <li class="">
                    <a href="{{ route('moderator.dashboard') }}">
                        <i data-feather="monitor"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="header">Quản Lý</li>

                <li class="treeview">
                    <a href="index.html#">
                        <i data-feather="grid"></i>
                        <span>Kiểm Duyệt</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        @if ($pendingArticlesCount + $pendingViolationsCount > 0)
                            <x-notification-badge :count="$pendingArticlesCount + $pendingViolationsCount" />
                        @endif
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('moderator.articles.index') }}" style="position: relative;">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Bài Viết
                                @if ($pendingArticlesCount > 0)
                                    <x-notification-badge :count="$pendingArticlesCount" />
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('moderator.violations.approves') }}" style="position: relative;">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Báo Cáo
                                @if ($pendingViolations > 0)
                                    <x-notification-badge :count="$pendingViolations" />
                                @endif
                            </a>
                        </li>

                        <li><a href="{{ route('moderator.articles.moderation-history.index') }}"><i
                                    class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Lịch
                                Sử Kiểm Duyệt</a>
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
                                Bài Viết Đã Lưu
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('moderator.viewed.articles') }}">
                                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                Bài Viết Đã Xem
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
