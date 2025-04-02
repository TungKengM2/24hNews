@extends('website.layouts.master')

@section('content')
    <main>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- ====== Tin tức nổi bật ====== -->
        <section class="tc-breaking-news-style1 pt-50 pb-50">
            <div class="container">
                <p class="color-999 text-uppercase mb-30 ltspc-1 fw-bold">Tin Tức Nổi Bật</p>
                <div class="tc-post-grid-default">
                    <div class="tc-slider-style1">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($featuredArticles as $article)
                                    <div class="swiper-slide">
                                        <a href="{{ Auth::check() ? route('articles.article', $article->slug) : url('/login-user') }}"
                                            class="item d-block">
                                            <div class="row gx-4 align-items-center">
                                                <div class="col-4">
                                                    <div class="img th-70 img-cover rounded">
                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                            alt="{{ $article->title }}">
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="content">
                                                        <h5 class="title">{{ $article->title }}</h5>
                                                        <div class="meta-bot mt-10">
                                                            <ul>
                                                                <li class="date"> <i class="la la-clock"></i>
                                                                    {{ $article->created_at->diffForHumans() }}</li>
                                                                <li class="hide-article ms-3">
                                                                    <a href="#" class="hide-btn" data-article-id="{{ $article->article_id }}" title="Ẩn bài viết này">
                                                                        <i class="la la-eye-slash"></i> Ẩn
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end tin tức nổi bật ====== -->

        <!-- ====== start columnist ====== -->
        <section class="tc-columnist-style1">
            <div class="container">
                <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                    <p class="color-000 text-uppercase mb-40 ltspc-1 lh-1">Tác giả nổi bật  </p>
                    <div class="row">
                        @forelse($topAuthors as $authorData)
                        <div class="col-lg-4 col-md-4 mb-4">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="{{ $authorData['author']->image ? asset('storage/'.$authorData['author']->image) : asset('/images/default-avatar.png') }}" alt="{{ $authorData['author']->username }}">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        {{ $authorData['author']->name ?? $authorData['author']->username }}
                                        <span class="text-warning ms-2">
                                            @for($i = 0; $i < floor($authorData['rating']); $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @if($authorData['rating'] - floor($authorData['rating']) >= 0.5)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                        </span>
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Chuyên đề</small>
                                        <p class="fsz-13px text-uppercase">{{ $authorData['specializes_in'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-lg-4 col-md-4 mb-4">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="assets/img/colums/1.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        Conor Bradley
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Specialize in</small>
                                        <p class="fsz-13px text-uppercase">Business, technology</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-4">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="assets/img/colums/2.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        Luis Diaz
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Specialize in</small>
                                        <p class="fsz-13px text-uppercase">Politic, lifestyle</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-4">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="assets/img/colums/3.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        Alberto Moreno
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Specialize in</small>
                                        <p class="fsz-13px text-uppercase">Entertaiment, culture, wolrd </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end columnist ====== -->

        <!-- ====== Bài viết tác giả bạn quan tâm ====== -->
        <section class="tc-technology-style1 pt-50 pb-50 bg-light">
            <div class="container">
                <h5 class="color-000 text-uppercase mb-30 ltspc-1 fw-bold">
                    Bài Viết Từ Tác Giả Bạn Quan Tâm <i class="la la-angle-right ms-1"></i>
                </h5>

                <div class="tc-post-list-style2">
                    <div class="items">
                        @auth
                            @if ($articlesfollow->isEmpty())
                                <div class="alert alert-info text-center">
                                    <i class="la la-info-circle me-2"></i>
                                    Bạn chưa theo dõi tác giả nào hoặc chưa có bài viết mới từ tác giả bạn theo dõi!
                                </div>
                            @else
                                @foreach ($articlesfollow as $article)
                                    <div
                                        class="item pt-30 pb-30 mt-30 border-1 border-top border-bottom brd-gray bg-white rounded shadow-sm">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover rounded">
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                        alt="{{ $article->title }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="#"
                                                            class="badge bg-primary text-white">{{ $article->category->name }}</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="{{ route('articles.article', $article->slug) }}"
                                                            class="text-dark">
                                                            {{ $article->title }}
                                                        </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-4">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="#"><i class="la la-calendar me-2"></i>
                                                                    {{ $article->created_at->format('d/m/Y') }}</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="#"><i class="la la-user me-2"></i>
                                                                    {{ $article->author->username }}</a>
                                                            </li>
                                                            <li class="views">
                                                                <a href="#"><i class="la la-eye me-2"></i>
                                                                    {{ $article->views ?? 0 }} Lượt Xem</a>
                                                            </li>
                                                            <li class="hide-article ms-5">
                                                                <a href="#" class="hide-btn" data-article-id="{{ $article->article_id }}" title="Ẩn bài viết này">
                                                                    <i class="la la-eye-slash me-2"></i>Ẩn
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="la la-exclamation-circle me-2"></i>
                                Vui lòng <a href="{{ url('/login-user') }}" class="alert-link">đăng nhập</a> để xem bài viết
                                từ tác giả bạn theo dõi.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end bài viết tác giả bạn quan tâm ====== -->

        <!-- ====== Xu hướng nóng ====== -->
        <section class="tc-trends-news-style1 pt-50 pb-50 bg-gray1">
            <div class="container">
                <div class="hot-trends-tabs-style1 mb-4">
                    <p class="color-999 text-uppercase ltspc-1 flex-shrink-0 me-4 pt-1 fw-bold">
                        <i class="ion-arrow-graph-up-right me-2"></i> Xu Hướng Nóng
                    </p>
                    <div class="links">
                        {{-- @foreach ($hottrendsArticles as $article)
                    <a class="link" href="{{ Auth::check() ? route('client.articles.article', $article->id) : url('/login-user') }}" class="item d-block">{{ $article->preview_contentt }}
                    </a>
                    @endforeach  --}}
                    </div>
                </div>
                <div class="section-content">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tc-trends-news-slider1 tc-slider-style2">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach ($D1Articles as $article)
                                            <div class="swiper-slide">
                                                <div class="tc-post-overlay-default">
                                                    <div class="img th-650 img-cover rounded">
                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                            alt="{{ $article->title }}">
                                                        <div class="tags">
                                                            <a href="">
                                                                {{ $article->category->name ?? 'Chưa phân loại' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="content ps-40 pe-40 pb-40">
                                                        <h2 class="title mb-20">
                                                            <a
                                                                href="{{ Auth::check() ? route('articles.article', $article->slug) : url('/login-user') }}">
                                                                {{ $article->title }}
                                                            </a>
                                                        </h2>
                                                        <div class="text mb-40">
                                                            {{ Str::limit($article->preview_content, 100, '...') }}
                                                        </div>
                                                        <div class="meta-bot lh-1">
                                                            <ul class="d-flex">
                                                                <li class="date me-5">
                                                                    <a href="#"><i class="la la-calendar me-2"></i>
                                                                        {{ $article->created_at->format('d/m/Y') }}</a>
                                                                </li>
                                                                <li class="author me-5">
                                                                    <a href="#"><i class="la la-user me-2"></i>
                                                                        {{ $article->author->name ?? 'Admin' }}</a>
                                                                </li>
                                                                <li class="views">
                                                                    <a href="#"><i
                                                                            class="la la-eye me-2"></i>{{ $article->views }}</a>
                                                                </li>
                                                                <li class="hide-article ms-5">
                                                                    <a href="#" class="hide-btn" data-article-id="{{ $article->article_id }}" title="Ẩn bài viết này">
                                                                        <i class="la la-eye-slash me-2"></i>Ẩn
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="tc-post-list-style1 bg-white p-3 rounded shadow">
                                <div class="tc-post-title-style1 mb-3">
                                    <h5 class="text-dark fw-bold">Top Bài Viết Thảo Luận</h5>
                                </div>

                                @if ($trendingPosts->isNotEmpty())
                                    @foreach ($trendingPosts as $index => $post)
                                        <a href="{{ Auth::check() ? route('articles.article', $post->slug) : url('/login-user') }}"
                                            class="item hover-main d-block p-2 text-dark border-bottom mb-2">
                                            <h2 class="num">{{ $index + 1 }}</h2>
                                            <div class="content">
                                                <span class="fsz-12px text-muted text-uppercase mb-2">
                                                    {{ $post->category->name ?? 'Chưa phân loại' }}
                                                </span>
                                                <h6 class="title">{{ $post->title }}</h6>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="text-center text-muted">Chưa có bài viết thịnh hành.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end xu hướng nóng ====== -->

        <!-- ====== Tin tức có thể quan tâm ====== -->
        <section class="tc-news-style1">
            <div class="container">
                <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                    <h5 class="color-000 text-uppercase mb-40 ltspc-1 fw-bold">Tin Tức Có Thể Quan Tâm
                        <i class="la la-angle-right ms-1"></i>
                    </h5>
                    <div class="row">
                        @foreach ($newsData as $data)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="news-card h-100 shadow-sm rounded overflow-hidden">
                                    <div class="img img-cover th-200">
                                        <img src="{{ $data['article']->thumbnail_url ? asset('storage/' . $data['article']->thumbnail_url) : 'https://via.placeholder.com/400' }}"
                                            alt="{{ $data['article']->title }}">
                                    </div>
                                    <div class="info p-3">
                                        <h6 class="category text-uppercase text-primary mb-2">
                                            {{ $data['category']->name }}
                                        </h6>
                                        <h5 class="title mb-3">{{ $data['article']->title }}</h5>
                                        <a href="{{ Auth::check() ? route('articles.article', $data['article']->slug) : url('/login-user') }}"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            Xem chi tiết <i class="la la-angle-right"></i>
                                        </a>
                                        @auth
                                        <a href="#" class="btn btn-sm btn-outline-secondary mt-2 hide-btn" data-article-id="{{ $data['article']->article_id }}" title="Ẩn bài viết này">
                                            <i class="la la-eye-slash"></i> Ẩn bài viết
                                        </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end tin tức có thể quan tâm ====== -->


        <!-- ====== start modals ====== -->

        {{-- <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <h1>News24h</h1>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-4">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1 fw-bold"> Giới Thiệu News24h <i
                        class="la la-angle-right ms-1"></i>
                </h6>
                <div class="text mb-4">
                    News24h là nền tảng tin tức hàng đầu Việt Nam, cung cấp thông tin chính xác, đa dạng và cập nhật 24/7.
                    Chúng tôi cam kết mang đến cho độc giả những tin tức chất lượng và đáng tin cậy từ mọi lĩnh vực.
                </div>

                <div class="mt-4">
                    <h6 class="color-000 mb-3 fw-bold">Tại sao chọn News24h?</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-newspaper-o text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Tin tức chính xác, đa chiều</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-bolt text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Cập nhật tin tức 24/7</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-users text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Cộng đồng độc giả lớn mạnh</p>
                        </div>
                    </div>
                </div>

                <div class="sidebar-contact-info mt-4 pt-4 border-top">
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1 fw-bold"> Liên Hệ & Theo Dõi <i
                            class="la la-angle-right ms-1"></i> </h6>
                    <ul class="m-0">
                        <li class="mb-3">
                            <i class="las la-map-marker me-2 color-main fs-5"></i>
                            <a href="#">Tòa nhà FPT Polytechnic., Cổng số 2, 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ
                                Liêm, Hà Nội</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-envelope me-2 color-main fs-5"></i>
                            <a href="#">bayanhtai@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-phone-volume me-2 color-main fs-5"></i>
                            <a href="#">0981 725 836</a>
                        </li>
                    </ul>
                    <div class="social-links mt-3">
                        <a href="#" class="me-2">
                            <i class="la la-twitter"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-facebook-f"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-instagram"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- ====== end modals ====== -->
    </main>
@endsection
