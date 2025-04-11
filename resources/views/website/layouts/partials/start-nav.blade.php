<nav class="navbar navbar-expand-lg navbar-light style-1">
    <div class="container p-0">
        <div class="mob-nav-toggles d-flex align-items-center justify-content-between">
            <button class="navbarList-icon me-lg-5" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                aria-controls="offcanvasExample">
                <span></span>
                <span></span>
            </button>
            <a href="home-default.html#" class="logo-brand d-block d-lg-none w-50 my-4">
                <h1>News24h</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active-home' : '' }}" href="{{ url('/') }}">
                        <i class="la la-home fs-4"></i>
                    </a>
                </li>

                {{-- dat them --}}
                @foreach ($categories as $category)
                    @if ($loop->iteration > 6)
                        @break
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.category.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach

                {{-- dat them --}}
            </ul>

            <div class="nav-side navbar-nav ms-auto mb-2 mb-lg-0">
                {{-- Notification Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="icon-link dropdown-toggle" id="notificationDropdown" role="button"
                        data-bs-toggle="dropdown">
                        <i class="la la-bell fs-4"></i>
                        @auth
                            @if ($unreadCount = auth()->user()->notifications()->whereNull('read_at')->where('type', 'App\Notifications\NewArticleFromFollowedAuthor')->count())
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 10px;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        @endauth
                    </a>
                    <ul class="dropdownMenu dropdown-menu-end" style="margin-top: 0; margin-top: -50px; width: 300px;"
                        aria-labelledby="notificationDropdown">
                        <li>
                            <h6 class="dropdown-header px-3">Thông báo mới</h6>
                        </li>
                        @auth
                            @forelse(auth()->user()->notifications()->whereNull('read_at')->where('type', 'App\Notifications\NewArticleFromFollowedAuthor')->take(5)->get() as $notification)
                                <li>
                                    <a class="dropdown-item d-flex align-items-start py-2 px-3"
                                        href="/articles/{{ $notification->data['article_slug'] }}"
                                        onclick="markNotificationAsRead('{{ $notification->id }}')">
                                        <div class="flex-shrink-0 me-2">
                                            <img src="{{ $notification->data['author_avatar'] ?? asset('images/default-avatar.png') }}"
                                                width="30" class="rounded-circle">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="d-flex justify-content-between">
                                                <span
                                                    class="fw-bold text-truncate">{{ $notification->data['author_name'] }}</span>
                                                <small
                                                    class="text-muted ms-2">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                            </div>
                                            <div class="text-truncate" style="max-width: 220px;">
                                                {{ Str::limit($notification->data['message'], 50) }}
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <div class="dropdown-item text-muted py-2 px-3">Không có thông báo mới</div>
                                </li>
                            @endforelse
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <div class="d-flex justify-content-between px-3 py-1">
                                    <a class="small" href="{{ route('notifications.index') }}">Xem tất cả</a>
                                    <a class="small" href="#"
                                        onclick="markAllNotificationsAsRead(); return false;">Đánh dấu đã đọc</a>
                                </div>
                            </li>
                        @else
                            <li><a class="dropdown-item py-2 px-3" href="{{ route('loginuser') }}">Đăng nhập để xem thông
                                    báo</a></li>
                        @endauth
                    </ul>
                </li>

                {{-- User Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="icon-link">
                        <i class="la la-user fs-4"></i>
                    </a>
                    <ul class="dropdownMenu" style="margin-top: 0; margin-top: -50px;" aria-labelledby="">
                        @if (Auth::check())
                            <li><a class="dropdown-item" href="{{ route('loginuser') }}">
                                    <i class="la la-tv fs-4"></i> Dashboard
                                </a></li>

                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="la la-sign-out fs-4"></i> Đăng Xuất
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        @else
                            <li><a class="dropdown-item" href="{{ route('loginuser') }}">
                                    <i class="la la-unlock fs-4"></i> Login
                                </a></li>
                        @endif
                    </ul>
                </li>

                {{-- Search Icon --}}
                <a class="icon-link search-btn-style1">
                    <i class="la la-search fs-4 sOpen-btn"></i>
                    <i class="la la-close fs-4 sClose-btn"></i>
                </a>
            </div>

            <script>
                function markNotificationAsRead(notificationId) {
                    fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(response => {
                        if (response.ok) {
                            updateNotificationCount();
                        }
                    });
                }

                function markAllNotificationsAsRead() {
                    fetch('/notifications/clear', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(response => {
                        if (response.ok) {
                            location.reload();
                        }
                    });
                }

                function updateNotificationCount() {
                    const badge = document.querySelector('#notificationDropdown .badge');
                    if (badge) {
                        fetch('/notifications/unread-count')
                            .then(response => response.json())
                            .then(data => {
                                if (data.count > 0) {
                                    badge.textContent = data.count;
                                    badge.style.display = 'block';
                                } else {
                                    badge.style.display = 'none';
                                }
                            });
                    }
                }

                // Update every 30 seconds
                setInterval(updateNotificationCount, 30000);
            </script>


        </div>
    </div>
</nav>
