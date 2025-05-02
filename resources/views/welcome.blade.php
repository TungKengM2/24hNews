@extends('website.layouts.master')

@section('content')
    <main>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- ====== Tin tức nổi bật ====== -->
        @if ($featuredArticles->isNotEmpty())
            <!-- Kiểm tra nếu có bài viết -->
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
                                                        <div class="img th-175vh img-cover rounded">
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
        @endif
        <!-- ====== end tin tức nổi bật ====== -->


        <!-- ====== Bài viết tác giả bạn quan tâm ====== -->
        <section class="tc-columnist-style1">
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


        <section class="tc-trends-news-style1 pt-50 pb-50 bg-gray1">
            <div class="container">
                <!-- ====== Xu Hướng Nóng ====== -->
                @if ($topTags->isNotEmpty())
                    <!-- Kiểm tra nếu có ít nhất 1 tag -->
                    <div class="hot-trends-tabs-style1 mb-4">
                        <p class="color-999 text-uppercase ltspc-1 flex-shrink-0 me-4 pt-1 fw-bold">
                            <i class="ion-arrow-graph-up-right me-2"></i> Xu Hướng Nóng
                        </p>
                        <!-- ====== 4 tag có nhiều sd trong nhiều bàiV nhất ====== -->
                        <div class="links">
                            @foreach ($topTags as $tag)
                                <a href="{{ route('tags.shows', ['tag' => $tag->tag_id]) }}" class="link item d-block">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                        <!-- ====== end 4 tag có nhiều sd trong nhiều bàiV nhất ====== -->
                    </div>
                @endif
                <!-- ====== end Xu Hướng Nóng ====== -->

                <div class="section-content">
                    <div class="row align-items-stretch">
                        @if ($D1Articles->isNotEmpty())
                            <!-- Kiểm tra nếu có bài viết trong D1Articles -->
                            <div class="col-lg-8">
                                <div class="tc-trends-news-slider1 tc-slider-style2">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            {{-- // top 3 bài viết nhiều lượt xem --}}
                                            @foreach ($D1Articles as $article)
                                                <div class="swiper-slide">
                                                    <div class="tc-post-overlay-default">
                                                        <div class="img th-650 img-cover rounded">
                                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                                alt="{{ $article->title }}">
                                                            <div class="tags">
                                                                <a
                                                                    href="">{{ $article->category->name ?? 'Chưa phân loại' }}</a>
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
                                                                        <a href="#"><i
                                                                                class="la la-calendar me-2"></i>
                                                                            {{ $article->created_at->locale('vi')->isoFormat('dddd, D [tháng] M, YYYY') }}
                                                                        </a>
                                                                    </li>
                                                                    <li class="author me-5">
                                                                        <a href="#"><i class="la la-user me-2"></i>
                                                                            {{ $article->author->name ?? 'Admin' }}</a>
                                                                    </li>
                                                                    <li class="views">
                                                                        <a href="#"><i
                                                                                class="la la-eye me-2"></i>{{ $article->views }}</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- // end top 3 bài viết nhiều lượt xem --}}
                                        </div>
                                    </div>
                                    <!-- arrows -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        @endif <!-- End D1Articles check -->

                        @if ($trendingPosts->isNotEmpty())
                            <!-- Kiểm tra nếu có bài viết trong trendingPosts -->
                            <div class="col-lg-4 h-110">
                                <div class="tc-post-list-style1 bg-white p-3 rounded shadow h-100">
                                    <div class="tc-post-title-style1 mb-3">
                                        <h5 class="fw-bold">Top Bài Viết Thảo Luận</h5>
                                    </div>
                                    {{-- // top 4 bài viết nhiều Bluan nhất 30 ngày trở lại --}}
                                    @foreach ($trendingPosts as $index => $post)
                                        <a href="{{ Auth::check() ? route('articles.article', $post->slug) : url('/login-user') }}"
                                            class="item hover-main d-block p-2  border-bottom mb-2">
                                            <h2 class="num">{{ $index + 1 }}</h2>
                                            <div class="content">
                                                <span class="fsz-12px text-muted text-uppercase mb-2">
                                                    {{ $post->category->name ?? 'Chưa phân loại' }}
                                                </span>
                                                <h6 class="title">{{ $post->title }}</h6>
                                            </div>
                                        </a>
                                    @endforeach
                                    {{-- // end top 4 bài viết nhiều Bluan nhất 30 ngày trở lại --}}
                                </div>
                            </div>
                        @else
                            <!-- Nếu không có trendingPosts, hiển thị thông báo -->
                            <div class="col-lg-4 h-110">
                                <p class="text-center text-muted">Chưa có bài viết thảo luận nổi bật nào.</p>
                            </div>
                        @endif <!-- End trendingPosts check -->
                    </div>
                </div>

            </div>
        </section>
        <!-- ====== end xu hướng nóng ====== -->

        <!-- start what's new -->
        <div class="container">
            @if ($latestPosts->isNotEmpty())
                <!-- Kiểm tra nếu có bài viết trong latestPosts -->
                <div class="tc-whatsnew-news-style8 bg-white p-30 mb-10">
                    <div class="section-title-style2 mb-30 align-items-center justify-content-between">
                        <h4 class="me-30 color-000">Bài Viết Mới Nhất</h4>
                        <a href="{{ route('article.news') }}" class="fsz-14px color-666 text-uppercase">Xem Thêm <i
                                class="la la-angle-right"></i></a>
                    </div>

                    <div class="tc-post-grid-style9">
                        <div class="row gx-5">

                            {{-- Bài to bên trái --}}
                            @if ($latestPosts->first())
                                <div class="col-lg-6 border-1 border-end brd-gray">
                                    <div class="item mb-4 mb-lg-0">
                                        <div class="img img-cover th-350">
                                            <img src="{{ asset('storage/' . $latestPosts[0]->thumbnail_url) }}"
                                                alt="{{ $latestPosts[0]->title }}">
                                        </div>
                                        <div class="info mt-30">
                                            <div class="tags">
                                                <a class="blue"
                                                    href="#">{{ $latestPosts->first()->category->name ?? 'Uncategorized' }}</a>
                                            </div>
                                            <h4 class="title mt-15">
                                                <a href="{{ route('articles.article', $latestPosts->first()->slug) }}"
                                                    class="hover-underline">
                                                    {{ $latestPosts->first()->title }}
                                                </a>
                                            </h4>
                                            <div class="text color-666 mt-20">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($latestPosts->first()->summary), 120) }}
                                            </div>
                                            <div class="meta-bot lh-1 mt-30">
                                                <a href="#" class="fsz-13px">
                                                    <i class="la la-clock me-1"></i>
                                                    {{ $article->created_at->locale('vi')->isoFormat('dddd, D [tháng] M, YYYY - HH:mm') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- 2 bài bên phải trên --}}
                            <div class="col-lg-3 border-1 border-end brd-gray">
                                @foreach ($latestPosts->skip(1)->take(2) as $post)
                                    <div class="item pb-30 mb-30 border-1 border-bottom brd-gray">
                                        <div class="img img-cover th-160">
                                            <img src="{{ asset('storage/' . $post->thumbnail_url) }}"
                                                alt="{{ $post->title }}">
                                        </div>
                                        <div class="info mt-20">
                                            <div class="tags">
                                                <a class="green"
                                                    href="#">{{ $post->category->name ?? 'Uncategorized' }}</a>
                                            </div>
                                            <h6 class="title mt-10 ltspc--1">
                                                <a href="{{ route('articles.article', $post->slug) }}"
                                                    class="hover-underline">
                                                    {{ \Illuminate\Support\Str::limit($post->title, 50) }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- 2 bài bên phải dưới --}}
                            <div class="col-lg-3">
                                @foreach ($latestPosts->skip(3)->take(2) as $post)
                                    <div class="item pb-30 mb-30 border-1 border-bottom brd-gray">
                                        <div class="img img-cover th-160">
                                            <img src="{{ asset('storage/' . $post->thumbnail_url) }}"
                                                alt="{{ $post->title }}">
                                        </div>
                                        <div class="info mt-20">
                                            <div class="tags">
                                                <a class="cyan"
                                                    href="#">{{ $post->category->name ?? 'Uncategorized' }}</a>
                                            </div>
                                            <h6 class="title mt-10 ltspc--1">
                                                <a href="{{ route('articles.article', $post->slug) }}"
                                                    class="hover-underline">
                                                    {{ \Illuminate\Support\Str::limit($post->title, 50) }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    {{-- Các bài link nhỏ --}}
                    <div class="line-posts pt-15 mt-30 border-1 border-top brd-gray">
                        <div class="row">
                            <div class="col-lg-6">
                                @foreach ($latestPosts->skip(5)->take(1) as $post)
                                    <a href="{{ route('articles.article', $post->slug) }}"
                                        class="fw-bold hover-main d-flex my-3 fsz-16px">
                                        <i class="ion-arrow-right-b me-3 mt-1"></i>
                                        {{ \Illuminate\Support\Str::limit($post->title, 70) }}
                                    </a>
                                @endforeach
                                @foreach ($latestPosts->skip(6)->take(1) as $post)
                                    <a href="{{ route('articles.article', $post->slug) }}"
                                        class="fw-bold hover-main d-flex my-3 fsz-16px">
                                        <i class="ion-arrow-right-b me-3 mt-1"></i>
                                        {{ \Illuminate\Support\Str::limit($post->title, 70) }}
                                    </a>
                                @endforeach
                                @foreach ($latestPosts->skip(7)->take(1) as $post)
                                    <a href="{{ route('articles.article', $post->slug) }}"
                                        class="fw-bold hover-main d-flex my-3 fsz-16px">
                                        <i class="ion-arrow-right-b me-3 mt-1"></i>
                                        {{ \Illuminate\Support\Str::limit($post->title, 70) }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="col-lg-6">
                                @foreach ($latestPosts->skip(8)->take(1) as $post)
                                    <a href="{{ route('articles.article', $post->slug) }}"
                                        class="fw-bold hover-main d-flex my-3 fsz-16px">
                                        <i class="ion-arrow-right-b me-3 mt-1"></i>
                                        {{ \Illuminate\Support\Str::limit($post->title, 70) }}
                                    </a>
                                @endforeach
                                @foreach ($latestPosts->skip(9)->take(1) as $post)
                                    <a href="{{ route('articles.article', $post->slug) }}"
                                        class="fw-bold hover-main d-flex my-3 fsz-16px">
                                        <i class="ion-arrow-right-b me-3 mt-1"></i>
                                        {{ \Illuminate\Support\Str::limit($post->title, 70) }}
                                    </a>
                                @endforeach
                                @foreach ($latestPosts->skip(10)->take(1) as $post)
                                    <a href="{{ route('articles.article', $post->slug) }}"
                                        class="fw-bold hover-main d-flex my-3 fsz-16px">
                                        <i class="ion-arrow-right-b me-3 mt-1"></i>
                                        {{ \Illuminate\Support\Str::limit($post->title, 70) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif <!-- End latestPosts check -->
        </div>
        <!-- end what's new -->


        @if ($mainPost)
            <section class="pt-0">
                <div class="container">
                    {{-- Tiêu đề --}}
                    <div class="tc-posts-tabs-style3">
                        <div class="section-title-style2 mb-40 align-items-end justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="section-title-style2 mb-30 ">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- 1. Bài chính --}}
                        <div class="col-lg-5">
                            <div class="tc-Post-overlay-style1">
                                <div class="item mb-5 mb-lg-0">
                                    @if ($mainPost)
                                        <div class="img th-525 img-cover radius-5 overflow-hidden">
                                            <a href="{{ route('articles.article', $mainPost->slug) }}"
                                                class="d-block h-100">
                                                <img src="{{ asset('storage/' . $mainPost->thumbnail_url) }}"
                                                    alt="{{ $mainPost->title }}">
                                            </a>
                                            <div class="tags-30 fsz-12px fw-500">
                                                <span class="bg-orange1 text-white text-uppercase rounded-pill px-3 py-1">
                                                    {{ $mainPost->category->name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="content p-30">
                                            <h3 class="title">
                                                <a
                                                    href="{{ route('articles.article', $mainPost->slug) }}">{{ $mainPost->title }}</a>
                                            </h3>
                                            <div class="meta-bot lh-1 mt-30 fsz-13px text-white">
                                                <i class="la la-clock"></i>
                                                {{ $mainPost->created_at->format('d/m/Y') }}
                                                <span class="color-999 ms-2">Đăng bởi
                                                    {{ $mainPost->author->username }}</span>
                                                @if ($mainPost->views > 0)
                                                    <span class="ms-3 fsz-12px color-999">{{ $mainPost->views }} lượt
                                                        xem</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- 2. Năm bài danh sách --}}
                        <div class="col-lg-4">
                            <div class="tc-post-list-style7">
                                @if (!empty($listPosts) && $listPosts->count())
                                    @foreach ($listPosts as $post)
                                        @if ($post)
                                            <div class="item mb-30">
                                                <div class="row gx-3">
                                                    <div class="col-4">
                                                        <a href="{{ route('articles.article', $post->slug) }}"
                                                            class="img img-cover radius-4 w-100 th-80">
                                                            <img src="{{ asset('storage/' . $post->thumbnail_url) }}"
                                                                alt="{{ $post->title }}">
                                                        </a>
                                                    </div>
                                                    <div class="col-8">
                                                        <h6 class="title">
                                                            <a href="{{ route('articles.article', $post->slug) }}">
                                                                {{ Str::limit($post->title, 50) }}
                                                            </a>
                                                        </h6>
                                                        <div class="date fsz-13px color-666 mt-10">
                                                            <i class="la la-clock"></i>
                                                            {{ $post->created_at->diffForHumans() }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- 3. Ô lưới + ba liên kết --}}
                        <div class="col-lg-3">
                            {{-- Ô lưới lớn --}}
                            @if ($gridPost)
                                <div class="tc-post-grid-style7 mt-5 mt-lg-0">
                                    <div class="item pb-30 border-bottom brd-gray">
                                        <a href="{{ route('articles.article', $gridPost->slug) }}"
                                            class="img img-cover radius-5 th-200 d-block">
                                            <img src="{{ asset('storage/' . $gridPost->thumbnail_url) }}"
                                                alt="{{ $gridPost->title }}">
                                        </a>
                                        <div class="tags-15 fsz-12px fw-500 mt-10">
                                            <span class="bg-orange1 text-white text-uppercase rounded-pill px-2 py-1">
                                                {{ $gridPost->category->name }}
                                            </span>
                                        </div>
                                        <h6 class="title mt-15">
                                            <a
                                                href="{{ route('articles.article', $gridPost->slug) }}">{{ $gridPost->title }}</a>
                                        </h6>
                                        <div class="meta-bot lh-1 mt-10 fsz-13px color-666">
                                            <i class="la la-clock"></i> {{ $gridPost->created_at->diffForHumans() }}
                                            @if ($gridPost->views > 0)
                                                <span class="ms-2 fsz-12px color-999">{{ $gridPost->views }} lượt
                                                    xem</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Ba liên kết văn bản --}}
                            @if (!empty($linkPosts) && $linkPosts->count())
                                @foreach ($linkPosts as $post)
                                    @if ($post)
                                        <div class="d-flex fsz-16px fw-bold mt-20">
                                            <i class="ion-arrow-right-b me-3 mt-1"></i>
                                            <a href="{{ route('articles.article', $post->slug) }}" class="flex-grow-1">
                                                {{ $post->title }}
                                            </a>
                                            @if ($post->views > 0)
                                                <span class="fsz-12px color-666">{{ $post->views }} lượt xem</span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <br>


        <!-- ====== start trending posts ====== -->
        @if ($weeklyTrendingArticles->isNotEmpty())
            <!-- Kiểm tra nếu có bài viết trong weeklyTrendingArticles -->
            <section class="">
                <div class="container bg-white">
                    <div class="content bg-white">
                        <div class="section-title-style2 mb-30">
                            <h3>Bài viết thịnh hành tuần này </h3>
                        </div>

                        <div class="tc-trends-news-slider2">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($weeklyTrendingArticles as $index => $article)
                                        <div class="swiper-slide">
                                            <div class="card-item">
                                                <div class="img img-cover">
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                        alt="{{ $article->title }}">
                                                    <span class="num">{{ $index + 1 }}</span>
                                                </div>
                                                <div class="info">
                                                    <div class="tags mt-20">
                                                        <a href="{{ route('client.category.show', $article->category->slug) }}"
                                                            class="bg-primary text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">
                                                            {{ $article->category->name }}
                                                        </a>
                                                    </div>
                                                    <h4 class="title mt-20">
                                                        <a href="{{ route('articles.article', $article->slug) }}"
                                                            class="hover-underline">
                                                            {{ $article->title }}
                                                        </a>
                                                    </h4>
                                                    <div class="meta-bot lh-1 text-capitalize color-666 fsz-13px mt-30">
                                                        <ul class="d-flex">
                                                            <li class="date me-4">
                                                                <i class="la la-calendar me-1"></i>
                                                                {{ $NewsArticle->created_at->diffForHumans() }}
                                                            </li>

                                                            <li class="views">
                                                                <i class="la la-eye me-1"></i> {{ $article->views }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- ====== end trending posts ====== -->



        <!-- ====== start Latest news ====== -->
        @if ($businessMainPost)
            <section class="tc-latest-news-style1">
                <div class="container">
                    <div class="section-content pt-50 pb-50 border-bottom border-1 brd-gray">

                        <!-- Section title -->
                        <p class="color-000 text-uppercase mb-30 ltspc-1">
                            <a href="{{ route('categories.show', 'kinh-doanh') }}">Kinh Doanh</a>
                            <i class="la la-angle-right ms-1"></i>
                        </p>

                        <div class="row">

                            <!-- Main big post -->
                            <div class="col-lg-5 border-end brd-gray border-1">
                                @if ($businessMainPost)
                                    <div class="tc-post-grid-default">
                                        <div class="item">
                                            <div class="img img-cover th-330 position-relative">
                                                <a href="{{ route('articles.article', $businessMainPost->slug) }}">
                                                    <img src="{{ asset('storage/' . $businessMainPost->thumbnail_url) }}"
                                                        alt="{{ $businessMainPost->title }}">
                                                </a>
                                            </div>
                                            <div class="content pt-50">
                                                @if ($businessMainPost->category)
                                                    <a href="{{ route('categories.show', $businessMainPost->category->slug) }}"
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                        {{ $businessMainPost->category->name }}
                                                    </a>
                                                @endif
                                                <h2 class="title mb-20">
                                                    <a href="{{ route('articles.article', $businessMainPost->slug) }}">
                                                        {{ $businessMainPost->title }}
                                                    </a>
                                                </h2>
                                                <div class="text color-666">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($businessMainPost->summary), 120) }}
                                                </div>
                                                <div class="meta-bot lh-1 mt-40">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <i class="la la-calendar me-2"></i>
                                                            {{ $businessMainPost->created_at->locale('vi')->isoFormat('dddd, D [tháng] M, YYYY') }}
                                                        </li>
                                                        <li class="author me-5">
                                                            @if ($businessMainPost->author)
                                                                <i class="la la-user me-2"></i>
                                                                {{ $businessMainPost->author->username }}
                                                            @endif
                                                        </li>
                                                        <li class="comment">
                                                            <i class="la la-eye me-2"></i> {{ $businessMainPost->views }}
                                                            Lượt Xem
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- List 5 posts -->
                            <div class="col-lg-4 border-end brd-gray border-1">
                                @if ($businessListPosts->isNotEmpty())
                                    <div class="tc-post-list-style2">
                                        <div class="items">
                                            @foreach ($businessListPosts as $item)
                                                <div class="item ">
                                                    <div class="row gx-3 align-items-center mb-1">
                                                        <div class="col-4">
                                                            <div class="img th- img-cover">
                                                                <a href="{{ route('articles.article', $item->slug) }}">
                                                                    <img src="{{ asset('storage/' . $item->thumbnail_url) }}"
                                                                        alt="{{ $item->title }}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="content">
                                                                @if ($item->category)
                                                                    <div
                                                                        class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                                        {{ $item->category->name }}
                                                                    </div>
                                                                @endif
                                                                <h5 class="title ltspc--1">
                                                                    <a href="{{ route('articles.article', $item->slug) }}"
                                                                        class="hover-underline">
                                                                        {{ $item->title }}
                                                                    </a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- 1 grid post + 3 link posts -->
                            <div class="col-lg-3">
                                @if ($businessGridPost)
                                    <div class="tc-post-grid-default border-1 border-bottom brd-gray pb-10">
                                        <div class="item">
                                            <div class="img img-cover th-200">
                                                <a href="{{ route('articles.article', $businessGridPost->slug) }}">
                                                    <img src="{{ asset('storage/' . $businessGridPost->thumbnail_url) }}"
                                                        alt="{{ $businessGridPost->title }}">
                                                </a>
                                            </div>
                                            <div class="content pt-30">
                                                @if ($businessGridPost->category)
                                                    <a href="{{ route('categories.show', $businessGridPost->category->slug) }}"
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                        {{ $businessGridPost->category->name }}
                                                    </a>
                                                @endif
                                                <h5 class="title ltspc--1 mb-10">
                                                    <a href="{{ route('articles.article', $businessGridPost->slug) }}">
                                                        {{ $businessGridPost->title }}
                                                    </a>
                                                </h5>
                                                <div class="text color-666">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($businessGridPost->summary), 60) }}
                                                </div>
                                                <div class="meta-bot lh-1 mt-20">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <i class="la la-calendar me-2"></i>
                                                            {{ $businessGridPost->created_at->format('d/m/Y') }}
                                                        </li>
                                                        <li class="comment">
                                                            <i class="la la-comment me-2"></i>
                                                            {{ $businessGridPost->comments_count ?? 0 }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($businessLinkPosts->isNotEmpty())
                                    <div class="pt-15">
                                        @foreach ($businessLinkPosts as $linkPost)
                                            <a href="{{ route('articles.article', $linkPost->slug) }}"
                                                class="d-flex my-3">
                                                <span
                                                    class="icon-6 rounded-circle bg-dark me-3 flex-shrink-0 op-4 mt-10"></span>
                                                <h6 class="fsz-16px">{{ $linkPost->title }}</h6>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- ====== end Latest news ====== -->



        <!-- ====== start columnist ====== -->
        @if (isset($topAuthors) && !$topAuthors->isEmpty())
            <section class="tc-columnist-style1">
                <div class="container ">
                    <div class="content pt-50 pb-50 border-1 border-top brd-gray ">

                        <p class="color-000 text-uppercase mb-40 ltspc-1 lh-1">Tác giả nổi bật </p>
                        <div class="row">
                            @foreach ($topAuthors as $authorData)
                                <div class="col-lg-4 col-md-4 mb-4">
                                    <div class="columnist-card d-flex align-items-center">
                                        <div
                                            class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                            <a
                                                href="{{ route('website.profileAuth', ['id' => $authorData['author']->user_id]) }}">
                                                <img src="{{ $authorData['author']->image ? asset('storage/' . $authorData['author']->image) : asset('/images/default-avatar.png') }}"
                                                    alt="{{ $authorData['author']->username }}">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <h6 class="name fsz-20px mb-10">
                                                <a
                                                    href="{{ route('website.profileAuth', ['id' => $authorData['author']->user_id]) }}">
                                                    {{ $authorData['author']->name ?? $authorData['author']->username }}
                                                </a>
                                            </h6>

                                            {{-- Rating --}}
                                            <div class="rating mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($authorData['rating']))
                                                        <i class="la la-star text-warning"></i>
                                                    @elseif ($i == ceil($authorData['rating']) && $authorData['rating'] - floor($authorData['rating']) > 0)
                                                        @if ($authorData['rating'] - floor($authorData['rating']) >= 0.75)
                                                            <i class="la la-star text-warning"></i>
                                                        @elseif ($authorData['rating'] - floor($authorData['rating']) >= 0.25)
                                                            <i class="la la-star-half-alt text-warning"></i>
                                                        @else
                                                            <i class="la la-star-o text-secondary"></i>
                                                        @endif
                                                    @else
                                                        <i class="la la-star-o text-secondary"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="text-muted ms-2">({{ number_format($authorData['rating'], 1) }})</span>
                                            </div>

                                            {{-- Specialization --}}
                                            <div class="jop-title">
                                                <small class="fsz-13px color-999">Chuyên đề</small>
                                                <p class="fsz-13px text-uppercase mb-0">
                                                    @if (!empty($authorData['specializes_slug']))
                                                        <a href="{{ route('client.category.author.show', ['categorySlug' => $authorData['specializes_slug'], 'authorId' => $authorData['author']->user_id]) }}"
                                                            class="text-primary">
                                                            {{ $authorData['specializes_in'] }}
                                                        </a>
                                                    @else
                                                        {{ $authorData['specializes_in'] }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </section>
        @endif
        <!-- ====== end columnist ====== -->



        <!-- ====== start another-news ====== -->
        @if ($topCategoriesWithArticles->isNotEmpty())
            <!-- Kiểm tra nếu có dữ liệu trong topCategoriesWithArticles -->
            <section class="another-news pt-50 pb-50 border-1 border-top brd-gray">
                <div class="container">
                    <h3 class="mb-10"></h3>
                    <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html"> Danh Mục Hàng Đầu </a>

                    <div class="content">
                        <div class="row">
                            @foreach ($topCategoriesWithArticles as $data)
                                @php
                                    $category = $data['category'];
                                    $main = $data['main_article'] ?? null;
                                    $subs = $data['sub_articles'] ?? [];
                                @endphp

                                <div class="col-lg-4">
                                    <p class="color-000 text-uppercase mb-30 ltspc-1">
                                        <a
                                            href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                                        <i class="la la-angle-right ms-1"></i>
                                    </p>

                                    <div class="row">
                                        <div class="col-12 {{ !$loop->last ? 'border-1 border-end brd-gray' : '' }}">
                                            {{-- Main article --}}
                                            @if ($main)
                                                <div class="tc-post-grid-default">
                                                    <div class="item">
                                                        <div class="img img-cover th-250">
                                                            @if ($main->thumbnail_url)
                                                                <img src="{{ asset('storage/' . $main->thumbnail_url) }}"
                                                                    alt="{{ $main->title }}">
                                                            @endif
                                                        </div>
                                                        <div class="content pt-20">
                                                            <a href="{{ route('categories.show', $category->slug) }}"
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                                {{ $category->name }}
                                                            </a>

                                                            <h4 class="title ltspc--1 mb-10">
                                                                <a
                                                                    href="{{ route('articles.article', $main->slug) }}">{{ $main->title }}</a>
                                                            </h4>

                                                            @if ($main->content)
                                                                <div class="text color-666">
                                                                    {!! \Illuminate\Support\Str::limit(strip_tags($main->content), 100, '...') !!}
                                                                </div>
                                                            @endif

                                                            <div class="meta-bot lh-1 mt-20">
                                                                <ul class="d-flex">
                                                                    <li class="date me-5">
                                                                        <a><i class="la la-calendar me-2"></i>
                                                                            {{ $NewsArticle->created_at->diffForHumans() }}</a>
                                                                    </li>
                                                                    <li class="comment">
                                                                        <a><i class="la la-comment me-2"></i>
                                                                            {{ $main->comments_count ?? 0 }}</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Sub articles --}}
                                            @if (count($subs))
                                                <div class="tc-post-list-style2 mt-30">
                                                    <div class="items">
                                                        @foreach ($subs as $article)
                                                            <a href="{{ route('articles.article', $article->slug) }}"
                                                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 {{ !$loop->last ? 'mt-15' : '' }}">
                                                                <div class="row gx-3 align-items-center">
                                                                    <div class="col-4">
                                                                        <div class="img th-70 img-cover">
                                                                            @if ($article->thumbnail_url)
                                                                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                                                    alt="{{ $article->title }}">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <div class="content">
                                                                            <small
                                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                                                {{ $category->name }}
                                                                            </small>
                                                                            <h5 class="title ltspc--1">
                                                                                {{ $article->title }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- ====== end another-news ====== -->






    </main>
@endsection
