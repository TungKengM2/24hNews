<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <div class="app-menu">
        <ul class="header-megamenu nav">
            <li class="btn-group nav-item">
                <a href="#" class="waves-effect waves-light nav-link push-btn btn-outline no-border btn-primary-light text-dark hover-white"
                    data-toggle="push-menu" role="button">
                    <i data-feather="align-left"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
            <!-- Notifications -->
            <li class="dropdown notifications-menu" style="position: relative;">
                <a href="#" class="waves-effect waves-light dropdown-toggle btn-outline no-border btn-info-light text-dark hover-white"
                    id="notificationDropdown" data-bs-toggle="dropdown" title="Notifications" style="position: relative; display: inline-block;">
                    <i class="fa fa-bell"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span id="notificationCount" class="badge badge-danger"
                            style="position: absolute; top: 6px; right: 5px; font-size: 12px; padding: 4px 7px; border-radius: 50%; background: red; color: white;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu animated bounceIn" aria-labelledby="notificationDropdown" style="width: 350px;">
                    <li class="header">
                        <div class="p-3">
                            <h4 class="mb-0">Notifications</h4>
                        </div>
                    </li>

                    <li>
                        <ul class="menu sm-scroll" id="notificationList">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <li class="notification-item p-3" id="notification-{{ $notification->id }}">
                                    <a href="#" onclick="openNotification('{{ $notification->id }}', '{{ addslashes($notification->data['message']) }}'); return false;"
                                        style="font-size: 16px; display: block; padding: 10px;">
                                        {{ Str::limit($notification->data['message'], 40, '...') }}
                                    </a>
                                </li>
                            @empty
                                <li class="text-muted dropdown-item p-3">Không có thông báo mới.</li>
                            @endforelse
                        </ul>
                    </li>

                    <li class="footer p-3">
                        <a href="#" style="display: block; text-align: center;">View all</a>
                    </li>
                </ul>
            </li>

            <!-- Custom Popup -->
            <div id="customPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1050;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; width: 400px; max-width: 90%; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #dee2e6;">
                        <h5 style="margin: 0; font-size: 18px;">Chi tiết thông báo</h5>
                        <button onclick="closePopup()" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
                    </div>
                    <div id="customPopupContent" style="padding: 20px; font-size: 16px; min-height: 100px;">
                        <!-- Nội dung thông báo sẽ được thêm vào đây -->
                    </div>
                    <div style="padding: 15px; border-top: 1px solid #dee2e6; text-align: right;">
                        <button onclick="closePopup()" style="padding: 8px 16px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Đóng</button>
                    </div>
                </div>
            </div>

            <!-- User Account -->
            <li class="dropdown user user-menu">
                <a href="#" class="waves-effect waves-light dropdown-toggle no-border p-5 text-dark hover-white"
                    data-bs-toggle="dropdown" title="User">
                    <img class="avatar avatar-pill" src="/admin/main/../images/avatar/3.jpg" alt="">
                </a>
                <ul class="dropdown-menu animated flipInX">
                    <li class="user-body">
                        <a class="dropdown-item" href="{{route('author.profile')}}">
                            <i class="ti-user text-muted me-2"></i> Profile
                        </a>
                        <a class="dropdown-item" href="{{route('author.change-password')}}">
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
        console.log("Popup opened"); // Debug log
    }

    function closePopup() {
        document.getElementById("customPopup").style.display = "none";
        console.log("Popup closed"); // Debug log
    }
</script>
