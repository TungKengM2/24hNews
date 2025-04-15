<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <div class="app-menu">
        <ul class="header-megamenu nav">
            <li class="btn-group nav-item">
                <a href="#"
                    class="waves-effect waves-light nav-link push-btn btn-outline no-border btn-primary-light text-dark hover-white"
                    data-toggle="push-menu" role="button">
                    <i data-feather="align-left"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
            <!-- Notifications -->

            @php
            $notificationCount = auth()->user()->unreadNotifications->count();
        @endphp

        <li class="dropdown notifications-menu" style="position: relative;">
            <a href="#"
                class="waves-effect waves-light dropdown-toggle btn-outline no-border btn-info-light text-dark hover-white"
                id="notificationDropdown" data-bs-toggle="dropdown" title="Notifications"
                style="position: relative; display: inline-block;">
                <i class="fa fa-bell"></i>
                <span id="notificationCount" class="badge badge-danger"
                    style="position: absolute; top: 6px; right: 5px; font-size: 12px; padding: 4px 7px; border-radius: 50%; background: red; color: white; display: {{ $notificationCount > 0 ? 'inline-block' : 'none' }};">
                    {{ $notificationCount }}
                </span>
            </a>

            <ul class="dropdown-menu animated bounceIn" aria-labelledby="notificationDropdown"
                style="width: 350px; max-height: 400px; overflow-y: auto;">
                <li class="header">
                    <div class="p-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" style="font-size: 16px; font-weight: 600;">Thông báo mới</h4>
                        <a href="#" id="clearNotifications" class="text-danger" style="font-size: 14px;">Xóa tất cả</a>
                    </div>
                </li>

                <li>
                    <ul class="menu sm-scroll" id="notificationList">
                        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                            @php
                                $type = $notification->data['type'] ?? 'default';
                                $icons = [
                                    'article_reported' => ['fa-exclamation-triangle', 'text-warning', 'Bài viết của bạn đã bị report'],
                                    'article_rejected' => ['fa-times-circle', 'text-danger', $notification->data['message']],
                                    'role_upgrade_rejected' => ['fa-times-circle', 'text-danger', $notification->data['message']],
                                    'default' => ['fa-info-circle', 'text-info', $notification->data['message'] ?? ''],
                                ];
                                [$icon, $color, $message] = $icons[$type] ?? $icons['default'];
                            @endphp

                            <li class="notification-item p-3" id="notification-{{ $notification->id }}"
                                style="border-bottom: 1px solid #f0f0f0;">
                                <a href="#"
                                    onclick="openNotification('{{ $notification->id }}', '{{ addslashes($message) }}'); return false;"
                                    style="font-size: 14px; display: block; padding: 10px; color: #333; text-decoration: none;">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fa {{ $icon }} {{ $color }}" style="font-size: 18px;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                {{ Str::limit($message, 40, '...') }}
                                            </div>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="text-muted dropdown-item p-3 text-center">
                                <i class="fa fa-bell-slash mb-2" style="font-size: 24px;"></i>
                                <div>Không có thông báo mới</div>
                            </li>
                        @endforelse
                    </ul>
                </li>

                <li class="footer p-3 text-center">
                    <a href="{{ route('notifications.index') }}" class="text-primary" style="font-size: 14px;">
                        Xem tất cả thông báo
                    </a>
                </li>
            </ul>
        </li>


            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll(".notification-item a").forEach(item => {
                        item.addEventListener("click", function(event) {
                            event.preventDefault();
                            let notificationId = this.getAttribute("onclick").match(/'([^']+)'/)[1];

                            fetch(`/notifications/${notificationId}/read`, {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute("content"),
                                        "X-Requested-With": "XMLHttpRequest"
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        document.getElementById(`notification-${notificationId}`)
                                            .remove();
                                        updateNotificationCount();
                                    }
                                });
                        });
                    });

                    document.getElementById("clearNotifications").addEventListener("click", function(event) {
                        event.preventDefault();
                        fetch(`/notifications/clear`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute("content"),
                                    "X-Requested-With": "XMLHttpRequest"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById("notificationList").innerHTML =
                                        '<li class="text-muted dropdown-item p-3 text-center"><i class="fa fa-bell-slash mb-2" style="font-size: 24px;"></i><div>Không có thông báo mới</div></li>';
                                    updateNotificationCount(0);
                                }
                            });
                    });
                });

                function updateNotificationCount(count = null) {
                    let badge = document.getElementById("notificationCount");
                    if (badge) {
                        if (count === null) {
                            count = parseInt(badge.innerText) - 1;
                        }
                        if (count > 0) {
                            badge.innerText = count;
                            badge.style.display = "inline-block";
                        } else {
                            badge.style.display = "none";
                        }
                    }
                }
            </script>

            <!-- Custom Popup -->
            <div id="customPopup"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1050;">
                <div
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; width: 500px; max-width: 90%; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #dee2e6;">
                        <h5 style="margin: 0; font-size: 18px; font-weight: 600;">Chi tiết thông báo</h5>
                        <button onclick="closePopup()"
                            style="background: none; border: none; font-size: 20px; cursor: pointer; color: #666;">&times;</button>
                    </div>
                    <div id="customPopupContent" style="padding: 20px; font-size: 16px; min-height: 100px; line-height: 1.6;">
                        <!-- Nội dung thông báo sẽ được thêm vào đây -->
                    </div>
                    <div style="padding: 15px; border-top: 1px solid #dee2e6; text-align: right;">
                        <button onclick="closePopup()"
                            style="padding: 8px 16px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Đóng</button>
                    </div>
                </div>
            </div>

            <!-- User Account -->
            <li class="dropdown user user-menu">
                <a href="#" class="waves-effect waves-light dropdown-toggle no-border p-5 text-dark hover-white"
                    data-bs-toggle="dropdown" title="User">
                    <img class="avatar rounded-circle"
                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                        alt="User Avatar">
                </a>
                <ul class="dropdown-menu animated flipInX">
                    <li class="user-body">
                        <a class="dropdown-item" href="{{ route('author.profile') }}">
                            <i class="ti-user text-muted me-2"></i> Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('author.change-password') }}">
                            <i class="ti-settings text-muted me-2"></i> Settings
                        </a>
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
                <a href="#" data-toggle="control-sidebar" title="Setting"
                    class="waves-effect waves-light btn-outline no-border btn-danger-light text-dark hover-white">
                    <i data-feather="settings"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
    feather.replace();

    function openNotification(id, message) {
        document.getElementById("customPopupContent").innerHTML = message;
        document.getElementById("customPopup").style.display = "block";

        fetch(`/notifications/${id}/read`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Xóa thông báo khỏi danh sách
                    let notificationItem = document.getElementById(`notification-${id}`);
                    if (notificationItem) {
                        notificationItem.remove();
                    }

                    // Cập nhật số lượng thông báo
                    let countElement = document.getElementById("notificationCount");
                    if (countElement) {
                        let count = parseInt(countElement.innerText, 10) || 0;
                        if (count > 1) {
                            countElement.innerText = count - 1;
                        } else {
                            countElement.remove(); // Nếu hết thông báo thì ẩn badge
                        }
                    }
                } else {
                    console.error("Failed to mark notification as read.");
                }
            })
            .catch(error => console.error("Error marking notification as read:", error));
    }

    function closePopup() {
        document.getElementById("customPopup").style.display = "none";
    }
</script>
