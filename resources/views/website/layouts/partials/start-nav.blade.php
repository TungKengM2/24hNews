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

                {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active-home' : '' }}" href="{{ url('/') }}">
                        <i class="la la-home fs-4"></i>
                    </a>
                </li> --}}

                {{-- dat them --}}
                @foreach ($parentCategories as $category)
    @if ($loop->iteration > 9)
        @break
    @endif

    <li class="nav-item dropdown">
        <a
            class="nav-link {{ $category->children->isNotEmpty() ? 'dropdown-toggle' : '' }}"
            href="{{ route('client.category.show', ['slug' => $category->slug]) }}"
            @if ($category->children->isNotEmpty())
                id="navbarDropdown{{ $loop->iteration }}"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            @endif
            onclick="window.location.href='{{ route('client.category.show', ['slug' => $category->slug]) }}'"
        >
            {{ $category->name }}
        </a>

        @if ($category->children->isNotEmpty())
            <ul class="dropdownMenu" aria-labelledby="navbarDropdown{{ $loop->iteration }}">
                @foreach ($category->children as $child)
                    <li>
                        <a class="dropdown-item" href="{{ route('client.category.show', ['slug' => $category->slug, 'childSlug' => $child->slug]) }}">
                            {{ $child->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
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
                            @if ($unreadCount = auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewArticleFromFollowedAuthor')->count())
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
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                @if($notification->type == 'App\Notifications\NewArticleFromFollowedAuthor')
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
                                                    <span class="fw-bold text-truncate">{{ $notification->data['author_name'] }}</span>
                                                    <small class="text-muted ms-2">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                </div>
                                                <div class="text-truncate" style="max-width: 220px;">
                                                    {{ Str::limit($notification->data['message'], 50) }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @elseif($notification->type === 'App\Notifications\RoleUpgradeRejected')
                                    <li>
                                        <a href="#" class="dropdown-item"
                                           onclick="event.preventDefault();
                                                    showRejectionReason('Yêu cầu nâng cấp tài khoản của bạn đã bị từ chối', '{{ $notification->data['reason'] }}');
                                                    markNotificationAsRead('{{ $notification->id }}');">
                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                            <span>Từ chối nâng cấp tài khoản</span>
                                            <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                                        </a>
                                    </li>
                                @endif
                            @empty
                                <li>
                                    <div class="dropdown-item text-muted py-2 px-3">Không có thông báo mới</div>
                                </li>
                            @endforelse
                            {{-- <li>
                                <hr class="dropdown-divider my-1">
                            </li> --}}
                            {{-- <li>
                                <div class="d-flex justify-content-between px-3 py-1">
                                    <a class="small" href="{{ route('notifications.index') }}">Xem tất cả</a>
                                    <a class="small" href="#"
                                        onclick="markAllNotificationsAsRead(); return false;">Đánh dấu đã đọc</a>
                                </div>
                            </li> --}}
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
                    <ul class="dropdownMenu mr-10 pr-5 " style="margin-top: 0; margin-top: -50px;" aria-labelledby="">
                        @if (Auth::check())
                            {{-- <li><a class="dropdown-item" href="@if (Auth::user()->role_id == 1){{ route('admin.dashboard') }}@elseif(Auth::user()->role_id == 2){{ route('author.dashboard') }}@elseif(Auth::user()->role_id == 3){{ route('moderator.dashboard') }}@else{{ route('user.dashboard') }}@endif">
                                    <i class="la la-tv fs-4"></i> Dashboard
                                </a></li> --}}

                            {{-- Kiểm tra vai trò và hiển thị các liên kết tương ứng --}}

                            @if (Auth::user()->role_id == 1)
                                {{-- admin  --}}
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="la la-tv fs-4"></i> Dashboard
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.viewed.articles') }}">
                                        <i class="la la-eye fs-4"></i> Tin đã xem
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.saved') }}">
                                        <i class="la la-bookmark fs-4"></i> Tin đã lưu
                                    </a></li>

                                <li><a class="dropdown-item" href="{{ route('admin.following') }}">
                                        <i class="la la-users fs-4"></i> Người đã theo dõi
                                    </a></li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.comments', ['user_id' => auth()->id()]) }}">
                                        <i class="la la-comments fs-4"></i> Hoạt Động Bình luận
                                    </a>
                                </li>
                            @elseif (Auth::user()->role_id == 2)
                                {{-- tác giả  --}}
                                <li><a class="dropdown-item" href="{{ route('author.dashboard') }}">
                                        <i class="la la-tv fs-4"></i> Dashboard
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('author.viewed.articles') }}">
                                        <i class="la la-eye fs-4"></i> Tin đã xem
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('author.saved') }}">
                                        <i class="la la-bookmark fs-4"></i> Tin đã lưu
                                    </a></li>

                                <li><a class="dropdown-item" href="{{ route('author.following') }}">
                                        <i class="la la-users fs-4"></i> Người đã theo dõi
                                    </a></li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('author.comments', ['user_id' => auth()->id()]) }}">
                                        <i class="la la-comments fs-4"></i> Hoạt Động Bình luận
                                    </a>
                                </li>
                            @elseif (Auth::user()->role_id == 3)
                                {{-- kiểm duyệt viên  --}}
                                <li><a class="dropdown-item" href="{{ route('moderator.dashboard') }}">
                                        <i class="la la-tv fs-4"></i> Dashboard
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('moderator.viewed.articles') }}">
                                        <i class="la la-eye fs-4"></i> Tin đã xem
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('moderator.saved') }}">
                                        <i class="la la-bookmark fs-4"></i> Tin đã lưu
                                    </a></li>

                                <li><a class="dropdown-item" href="{{ route('moderator.following') }}">
                                        <i class="la la-users fs-4"></i> Người đã theo dõi
                                    </a></li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('moderator.comments', ['user_id' => auth()->id()]) }}">
                                        <i class="la la-comments fs-4"></i> Hoạt Động Bình luận
                                    </a>
                                </li>
                            @elseif (Auth::user()->role_id == 4)
                                {{-- user  --}}
                                {{-- dat them hiển thị profile user --}}
                                <li><a class="dropdown-item"
                                        href="{{ route('website.profileUser', ['id' => auth()->id()]) }}">
                                        <i class="la la-tv fs-4"></i> Thông Tin Tài Khoản
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('viewed.articles') }}">
                                        <i class="la la-eye fs-4"></i> Tin đã xem
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.saved') }}">
                                        <i class="la la-bookmark fs-4"></i> Tin đã lưu
                                    </a></li>

                                <li><a class="dropdown-item" href="{{ route('user.following') }}">
                                        <i class="la la-users fs-4"></i> Người đã theo dõi
                                    </a></li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('user.comments', ['user_id' => auth()->id()]) }}">
                                        <i class="la la-comments fs-4"></i> Hoạt Động Bình luận
                                    </a>
                                </li>
                                {{-- dat them --}}
                                <li><a class="dropdown-item" href="{{ route('user.change-password') }}">
                                        <i class="la la-lock fs-4"></i> Đổi Mật Khẩu
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.upgrade') }}">

                                        <i class="la la-pen fs-4 "></i>
                                        Nâng Cấp Lên Tác Giả
                                    </a>
                                </li>
                            @endif

                            {{-- Đăng Xuất --}}
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
                            {{-- Liên kết Đăng nhập --}}
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
                function showRejectionReason(message, reason) {
                    // Tạo và hiển thị modal
                    const modal = document.createElement('div');
                    modal.className = 'modal fade';
                    modal.id = 'rejectionModal';
                    modal.innerHTML = `
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Từ chối nâng cấp tài khoản</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>${message}</p>
                                    <p class="text-danger"><strong>Lý do:</strong> ${reason}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);

                    const modalInstance = new bootstrap.Modal(modal);
                    modalInstance.show();

                    // Xóa modal khi đóng
                    modal.addEventListener('hidden.bs.modal', function () {
                        document.body.removeChild(modal);
                    });
                }

                function markNotificationAsRead(id) {
                    fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật UI sau khi đánh dấu đã đọc
                            const notificationCount = document.querySelector('.badge');
                            if (notificationCount) {
                                const currentCount = parseInt(notificationCount.textContent);
                                if (currentCount > 1) {
                                    notificationCount.textContent = currentCount - 1;
                                } else {
                                    notificationCount.style.display = 'none';
                                }
                            }
                        }
                    });
                }

                function markAllNotificationsAsRead() {
                    fetch('/notifications/mark-all-read', {
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
