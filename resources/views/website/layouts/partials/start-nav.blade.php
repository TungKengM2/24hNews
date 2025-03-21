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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="page-author.html#" id="navbarDropdown1" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Blog
                    </a>
                    <ul class="dropdownMenu" aria-labelledby="navbarDropdown1">
                        <li><a class="dropdown-item" href="page-blog.html">Blog</a></li>
                        <li><a class="dropdown-item" href="{{url('/profile')}}">authors</a></li>
                        <li><a class="dropdown-item" href="page-author-details.html">author details</a></li>
                    </ul>
                </li>

                {{-- dat them --}}
                @foreach ($categories as $category)
                @if ($category->is_active == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.category.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endif
                @endforeach
                 {{-- dat them --}}
            </ul>

                <div class="nav-side">
                    <a href="{{ route('loginuser') }} " class="icon-link">
                        <i class="la la-user fs-4">
                        </i>
                    </a>
                    <a class="icon-link search-btn-style1">
                        <i class="la la-search fs-4 sOpen-btn"></i>
                        <i class="la la-close fs-4 sClose-btn"></i>
                    </a>
                </div>
        </div>
    </div>
</nav>
