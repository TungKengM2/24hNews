<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <div class="app-menu">
        {{-- <ul class="header-megamenu nav">
            <li class="btn-group nav-item">
                <a href="index.html#"
                    class="waves-effect waves-light nav-link push-btn btn-outline no-border btn-primary-light text-dark hover-white"
                    data-toggle="push-menu" role="button">
                    <i data-feather="align-left"></i>
                </a>
            </li>
        </ul> --}}
    </div>

    <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
            <!-- Notifications -->
            <li class="dropdown notifications-menu">
                <a href="index.html#"
                    class="waves-effect waves-light dropdown-toggle btn-outline no-border btn-info-light text-dark hover-white"
                    data-bs-toggle="dropdown" title="Notifications">
                    <i data-feather="bell"></i>
                </a>
                <ul class="dropdown-menu animated bounceIn">

                    <li class="header">
                        <div class="p-20">
                            <div class="flexbox">
                                <div>
                                    <h4 class="mb-0 mt-0">Notifications</h4>
                                </div>
                                <div>
                                    <a href="index.html#" class="text-danger">Clear All</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu sm-scrol">
                            <li>
                                <a href="index.html#">
                                    <i class="fa fa-users text-info"></i> Curabitur id eros quis nunc
                                    suscipit blandit.
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <i class="fa fa-warning text-warning"></i> Duis malesuada justo eu
                                    sapien elementum, in semper diam posuere.
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <i class="fa fa-users text-danger"></i> Donec at nisi sit amet tortor
                                    commodo porttitor pretium a erat.
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <i class="fa fa-shopping-cart text-success"></i> In gravida mauris et
                                    nisi
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <i class="fa fa-user text-danger"></i> Praesent eu lacus in libero
                                    dictum fermentum.
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <i class="fa fa-user text-primary"></i> Nunc fringilla lorem
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <i class="fa fa-user text-success"></i> Nullam euismod dolor ut quam
                                    interdum, at scelerisque ipsum imperdiet.
                                </a>
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
                    <img class="avatar avatar-pill" src="/admin/main/../images/avatar/3.jpg" alt="">
                </a>
                <ul class="dropdown-menu animated flipInX">
                    <li class="user-body">
                        <a class="dropdown-item" href="{{ route('profile') }}"><i
                                class="ti-settings text-muted me-2"></i>
                            Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti-lock text-muted me-2"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
