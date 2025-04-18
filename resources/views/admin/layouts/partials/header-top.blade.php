<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <div class="app-menu">
        <ul class="header-megamenu nav">
            <li class="btn-group nav-item">
                <a href="index.html#"
                    class="waves-effect waves-light nav-link push-btn btn-outline no-border btn-primary-light text-dark hover-white"
                    data-toggle="push-menu" role="button">
                    <i data-feather="align-left"></i>
                </a>
            </li>
            {{-- <li class="btn-group d-lg-inline-flex d-none">
                <div class="app-menu">
                    <div class="search-bx mx-5">
                        <form>
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Search" aria-label="Search"
                                    aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn" type="submit" id="button-addon3"><i
                                            data-feather="search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </li> --}}
            {{-- <li class="btn-group nav-item d-none d-xl-inline-block">
                <a href="contact_app_chat.html"
                    class="waves-effect waves-light nav-link btn-outline no-border svg-bt-icon btn-info-light text-dark hover-white"
                    title="Chat">
                    <i data-feather="message-circle"></i>
                </a>
            </li> --}}
            {{-- <li class="btn-group nav-item d-none d-xl-inline-block">
                <a href="mailbox.html"
                    class="waves-effect waves-light nav-link btn-outline no-border svg-bt-icon btn-danger-light text-dark hover-white"
                    title="Mailbox">
                    <i data-feather="at-sign"></i>
                </a>
            </li> --}}
            {{-- <li class="btn-group nav-item d-none d-xl-inline-block">
                <a href="extra_taskboard.html"
                    class="waves-effect waves-light btn-outline no-border nav-link svg-bt-icon btn-success-light text-dark hover-white"
                    title="Taskboard">
                    <i data-feather="clipboard"></i>
                </a>
            </li> --}}
        </ul>
    </div>

    <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
            {{-- <li class="btn-group nav-item d-lg-inline-flex d-none">
                <a href="index.html#" data-provide="fullscreen"
                    class="waves-effect waves-light nav-link btn-outline no-border full-screen btn-warning-light text-dark hover-white"
                    title="Full Screen">
                    <i data-feather="maximize"></i>
                </a>
            </li> --}}
            <!-- Notifications -->
            <li class="dropdown notifications-menu">
                <a href="#" class="waves-effect waves-light dropdown-toggle btn-outline no-border btn-info-light text-dark hover-white position-relative"
                    data-bs-toggle="dropdown" title="Notifications">
                    <i data-feather="bell"></i>
                    @php
                        $pendingCount = \App\Models\Article::where('status', 'pending')->count();
                        $pendingViolations = \App\Models\Violation::where('status', 'pending')->count();

                        // Lấy danh sách yêu cầu nâng cấp với thời gian
                        $pendingUpgradeRequests = \App\Models\Approval::where('type', 'role_upgrade')
                            ->where('status', 'pending')
                            ->first();
                        $pendingUpgradeCount = \App\Models\Approval::where('type', 'role_upgrade')
                            ->where('status', 'pending')
                            ->count();

                        $totalPending = $pendingCount + $pendingViolations + ($pendingUpgradeCount ?? 0);

                        // Lấy danh sách bài viết chờ lâu với thời gian
                        $longPendingArticles = \App\Models\Article::where('status', 'pending')
                            ->where('created_at', '<', now()->subMinutes(30))
                            ->first();
                        $longPendingCount = \App\Models\Article::where('status', 'pending')
                            ->where('created_at', '<', now()->subMinutes(30))
                            ->count();

                        // Lấy bài viết pending mới nhất
                        $latestPendingArticle = \App\Models\Article::where('status', 'pending')
                            ->latest()
                            ->first();
                    @endphp

                    @if ($totalPending > 0)
                        <span class="badge bg-danger rounded-circle position-absolute"
                              style="top: 0px; right: 0px; font-size: 10px; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                            {{ $totalPending }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu shadow border-0" style="width: 280px; right: 0; left: auto; padding: 0; margin-top: 10px;">
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                        <span class="fw-medium" style="font-size: 14px;">Thông báo mới</span>
                        <a href="#" class="text-danger text-decoration-none" style="font-size: 13px;">Xóa tất cả</a>
                    </div>

                    @if ($totalPending > 0)
                        @if ($pendingCount > 0 && $latestPendingArticle)
                            <div class="border-bottom">
                                <a href="{{ route('admin.articles.approves') }}" class="d-block px-3 py-2 text-decoration-none text-dark">
                                    <div class="text-secondary" style="font-size: 12px;">{{ $latestPendingArticle->created_at->diffForHumans() }}</div>
                                    <div class="fw-medium mb-1">Bài viết chờ duyệt</div>
                                    <div class="text-secondary" style="font-size: 13px;">Có {{ $pendingCount }} bài viết đang chờ duyệt</div>
                                </a>
                            </div>
                        @endif

                        @if ($longPendingCount > 0 && $longPendingArticles)
                            <div class="border-bottom">
                                <a href="{{ route('admin.articles.approves') }}" class="d-block px-3 py-2 text-decoration-none text-dark">
                                    <div class="text-secondary" style="font-size: 12px;">{{ $longPendingArticles->created_at->diffForHumans() }}</div>
                                    <div class="fw-medium mb-1">Bài viết chờ lâu</div>
                                    <div class="text-secondary" style="font-size: 13px;">{{ $longPendingCount }} bài viết chờ duyệt quá 30 phút</div>
                                </a>
                            </div>
                        @endif

                        @if ($pendingUpgradeCount > 0 && $pendingUpgradeRequests)
                            <div class="border-bottom">
                                <a href="{{ route('admin.approvals.index') }}" class="d-block px-3 py-2 text-decoration-none text-dark">
                                    <div class="text-secondary" style="font-size: 12px;">{{ $pendingUpgradeRequests->created_at->diffForHumans() }}</div>
                                    <div class="fw-medium mb-1">Yêu cầu nâng cấp tài khoản</div>
                                    <div class="text-secondary" style="font-size: 13px;">Có {{ $pendingUpgradeCount }} yêu cầu nâng cấp mới</div>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash text-secondary opacity-25" style="font-size: 24px;"></i>
                            <div class="text-secondary mt-2" style="font-size: 13px;">Không có thông báo mới</div>
                        </div>
                        <div class="border-top">
                            <a href="#" class="d-block text-center text-primary text-decoration-none py-2" style="font-size: 13px;">
                                Xem tất cả thông báo
                            </a>
                        </div>
                    @endif
                </ul>
            </li>

            <!-- User Account-->
            <li class="dropdown user user-menu">
                <a href="index.html#"
                    class="waves-effect waves-light dropdown-toggle no-border p-5 text-dark hover-white"
                    data-bs-toggle="dropdown" title="User">
                    <img class="avatar rounded-circle"
                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                        alt="User Avatar">
                </a>
                <ul class="dropdown-menu animated flipInX">
                    <li class="user-body">
                        <a class="dropdown-item" href="{{ route('admin.profile') }}"><i
                                class="ti-user text-muted me-2"></i>
                            Profile</a>
                        {{-- <a class="dropdown-item" href="index.html#"><i class="ti-wallet text-muted me-2"></i> My
                            Wallet</a>
                        <a class="dropdown-item" href="index.html#"><i class="ti-settings text-muted me-2"></i>
                            Settings</a> --}}
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti-lock text-muted me-2"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
                <a href="index.html#" data-toggle="control-sidebar" title="Setting"
                    class="waves-effect waves-light btn-outline no-border btn-danger-light text-dark hover-white">
                    <i data-feather="settings"></i>
                </a>
            </li>

        </ul>
    </div>
</nav>
