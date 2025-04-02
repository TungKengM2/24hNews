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
            <li class="dropdown notifications-menu" style="position: relative;">
                <a href="index.html#"
                    class="waves-effect waves-light dropdown-toggle btn-outline no-border btn-info-light text-dark hover-white"
                    data-bs-toggle="dropdown" title="Notifications" style="position: relative; display: inline-block;">
                    <i data-feather="bell"></i>
                    @php
                        $pendingCount = \App\Models\Article::where('status', 'pending')->count();
                        $pendingViolations = \App\Models\Violation::where('status', 'pending')->count();
                        $totalPending = $pendingCount + $pendingViolations;
                    @endphp

                    @if ($pendingCount > 0 || $pendingViolations > 0)
                        <span class="badge badge-danger"
                            style="position: absolute; top: 6px; right: 5px; font-size: 10px; padding: 2px 5px; border-radius: 50%; line-height: 1; background: red; color: white;">
                            {{ $totalPending }}
                        </span>
                    @endif

                </a>
                <ul class="dropdown-menu animated bounceIn">
                    <li class="header">
                        <div class="p-20">
                            <div class="flexbox">
                                <div>
                                    <h4 class="mb-0 mt-0">Notifications</h4>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <ul class="menu sm-scrol">
                            <li>
                                @if ($pendingCount > 0 && $pendingViolations > 0)
                                    <a href="{{ route('admin.articles.approves') }}">
                                        {{ "Có $pendingCount bài viết và $pendingViolations vi phạm đang chờ duyệt!" }}
                                    </a>
                                @elseif ($pendingCount > 0)
                                    <a href="{{ route('admin.articles.approves') }}">
                                        {{ "Có $pendingCount bài viết đang chờ duyệt!" }}
                                    </a>
                                @elseif ($pendingViolations > 0)
                                    <a href="{{ route('admin.violations.approves') }}">
                                        {{ "Có $pendingViolations vi phạm đang chờ duyệt!" }}
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="index.html#">View all</a>
                    </li>
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
