@extends('website.layouts.master')

@section('content')

    <main>

        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!-- ====== start breaking news ====== -->
        <section class="tc-breaking-news-style1 pt-50 pb-50">
            <div class="container">
                <p class="color-999 text-uppercase mb-30 ltspc-1">Báo Mới</p>
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
                                                    <div class="img th-70 img-cover">
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
        <!-- ====== end breaking news ====== -->

        <!-- ====== start trends news ====== -->
        <section class="tc-trends-news-style1 pt-50 pb-50 bg-gray1">
            <div class="container">
                <div class="hot-trends-tabs-style1 mb-4">
                    <p class="color-999 text-uppercase ltspc-1 flex-shrink-0 me-4 pt-1"> <i
                            class="ion-arrow-graph-up-right me-2"></i> Hot Nhất Hiện Nay </p>
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
                                                    <div class="img th-650 img-cover">
                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                            alt="{{ $article->title }}">
                                                        <div class="tags">
                                                            <a href="">
                                                                {{ $article->category->name ?? 'Uncategorized' }}
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
                                                                        {{ $article->created_at->format('M d, Y') }}</a>
                                                                </li>
                                                                <li class="author me-5">
                                                                    <a href="#"><i class="la la-user me-2"></i> by
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


                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="tc-post-list-style1 bg-white p-3 rounded shadow">
                                <div class="tc-post-title-style1">
                                    <a href="#" class="text-dark fw-bold">Top Bài Viết Bàn Luận</a>
                                </div>

                                @if ($trendingPosts->isNotEmpty())
                                    @foreach ($trendingPosts as $index => $post)
                                        <a href="{{ Auth::check() ? route('articles.article', $post->slug) : url('/login-user') }}"
                                            class="item hover-main d-block p-2 text-dark">
                                            <h2 class="num">{{ $index + 1 }}</h2>
                                            <div class="content">
                                                <span class="fsz-12px text-muted text-uppercase mb-2">
                                                    {{ $post->category->name ?? 'Uncategorized' }}
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
        <!-- ====== end trends news ====== -->



        <!-- ====== Top Nhà Báo Nổi Bật ====== -->
        <!-- ====== end download ====== -->

        <!-- ====== start modals ====== -->

        <section class="tc-news-style1">
            <div class="container">
                <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                    <p class="color-000 text-uppercase mb-40 ltspc-1">Tin Tức Có Thể Quan Tâm<i
                            class="la la-angle-right ms-1"></i></p>
                    <div class="row">
                        @foreach ($newsData as $data)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="news-card">
                                    <div class="img img-cover th-200 rounded">
                                        <img src="{{ $data['article']->thumbnail_url ? asset('storage/' . $data['article']->thumbnail_url) : 'https://via.placeholder.com/400' }}"
                                            alt="{{ $data['article']->title }}">



                                    </div>
                                    <div class="info p-3">
                                        <h6 class="category text-uppercase text-primary mb-2">
                                            {{ $data['category']->name }}
                                        </h6>
                                        <h5 class="title mb-2">{{ $data['article']->title }}</h5>


                                        <a href="{{ Auth::check() ? route('articles.article', $data['article']->slug) : url('/login-user') }}"
                                            class="item hover-main d-block p-2 text-dark">
                                            Xem chi tiết <i class="la la-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>

        <!-- ====== start breaking news ====== -->
        {{-- <section class="tc-breaking-news-style1 pt-50 pb-50">
        <div class="container">
            <p class="color-999 text-uppercase mb-30 ltspc-1">breaking news</p>
            <div class="tc-post-grid-default">
                <div class="tc-slider-style1">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="page-single-post-creative.html" class="item d-block">
                                    <div class="row gx-4 align-items-center">
                                        <div class="col-4">
                                            <div class="img th-70 img-cover">
                                                <img src="{{ asset('client/img/latest/3.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="content">
                                                <h5 class="title">Discover the secret in Sahara desert</h5>
                                                <div class="meta-bot mt-10">
                                                    <ul>
                                                        <li class="date"> <i class="la la-clock"></i> 24 Minutes ago
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-single-post-creative.html" class="item d-block">
                                    <div class="row gx-4 align-items-center">
                                        <div class="col-4">
                                            <div class="img th-70 img-cover">
                                                <img src="{{ asset('client/img/latest/4.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="content">
                                                <h5 class="title">Economic policy between England & Scotland</h5>
                                                <div class="meta-bot mt-10">
                                                    <ul>
                                                        <li class="date"> <i class="la la-clock"></i> 3 Hours ago
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-single-post-creative.html" class="item d-block">
                                    <div class="row gx-4 align-items-center">
                                        <div class="col-4">
                                            <div class="img th-70 img-cover">
                                                <img src="{{ asset('client/img/latest/5.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="content">
                                                <h5 class="title"> Make Poetry, Not War! </h5>
                                                <div class="meta-bot mt-10">
                                                    <ul>
                                                        <li class="date"> <i class="la la-clock"></i> 15 Hours ago
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-single-post-creative.html" class="item d-block">
                                    <div class="row gx-4 align-items-center">
                                        <div class="col-4">
                                            <div class="img th-70 img-cover">
                                                <img src="{{ asset('client/img/latest/6.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="content">
                                                <h5 class="title">Economic policy between England & Scotland</h5>
                                                <div class="meta-bot mt-10">
                                                    <ul>
                                                        <li class="date"> <i class="la la-clock"></i> 3 Hours ago
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- arrows -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
        </section> --}}
        <!-- ====== end breaking news ====== -->

        <!-- ====== start trends news ====== -->

        <!-- ====== end trends news ====== -->

        <!-- ====== start google web stories ====== -->
        {{-- <section class="tc-google-stories-style1">
        <div class="container">
            <div class="section-content pt-70 pb-70 border-0 border-bottom brd-gray">
                <p class="color-000 text-uppercase mb-30 ltspc-1">google web stories</p>
                <div class="tc-google-stories-slider1 tc-slider-style1">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="home-default.html#" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/1.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        Kayak stories
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item seen">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/2.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        6 Tips Succe ...
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/3.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        PS Controller
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/4.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        What’s love in ...
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/5.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        News war Uk ...
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/6.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        Top Real Est ...
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/7.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        Top Real Est ...
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/8.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        The Moment
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="page-blog.html" class="story-item">
                                    <div class="img img-cover">
                                        <img src="client/img/google-stories/3.png" alt="">
                                    </div>
                                    <div class="title fsz-14px color-000 mt-10">
                                        PS Controller
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- arrows -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section> --}}
        <!-- ====== end google web stories ====== -->

        <!-- ====== start Latest news ====== -->
        <section class="tc-latest-news-style1">
            <div class="container">
                <div class="section-content pt-50 pb-50 border-bottom border-1 brd-gray">
                    <p class="color-000 text-uppercase mb-30 ltspc-1"><a href="page-blog.html"> latest news </a> <i
                            class="la la-angle-right ms-1"></i>
                    </p>
                    <div class="row">
                        <div class="col-lg-5 border-end brd-gray border-1">
                            <div class="tc-post-grid-default">
                                <div class="item">
                                    <div class="img img-cover th-330">
                                        <img src="client/assets/img/latest/1.png" alt="">
                                        <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity class="video_icon icon-70">
                                            <i class="ion-play"></i>
                                        </a>
                                    </div>
                                    <div class="content pt-30">
                                        <a href="page-blog.html"
                                            class="news-cat color-999 fsz-13px text-uppercase mb-10">politics</a>
                                        <h2 class="title mb-20">
                                            <a href="page-single-post-features.html">Biden asks Congress for $33 billion
                                                to support Ukraine</a>
                                        </h2>
                                        <div class="text color-666">
                                            The social-media company is in discussions to sell itself to Elon, a
                                            dramatic turn of events just 11 days after the [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-40">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec
                                                        14,
                                                        2022</a>
                                                </li>
                                                <li class="author me-5">
                                                    <a href="home-default.html#"><i class="la la-user me-2"></i> by Admin
                                                    </a>
                                                </li>
                                                <li class="comment">
                                                    <a href="home-default.html#"><i class="la la-comment me-2"></i> 55
                                                        Comments</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 border-end brd-gray border-1">
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/assets/img/latest/3.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        politics
                                                    </div>
                                                    <h5 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"
                                                            class="hover-underline">Disputes in the South China
                                                            Sea show no sign of ending</a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/assets/img/latest/4.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">sport
                                                        <b class="text-danger"> <i
                                                                class="icon-6 rounded-circle bg-danger ms-2 me-1 d-inline-block"></i>
                                                            live</b>
                                                    </div>
                                                    <h5 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"
                                                            class="hover-underline">Live of MLB Baseball 2022:
                                                            NY Yankees Vs NY Mets</a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/assets/img/latest/5.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        lifestyle
                                                    </div>
                                                    <h5 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"
                                                            class="hover-underline">Paddling in Miami Beach</a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/assets/img/latest/6.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        business
                                                    </div>
                                                    <h5 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"
                                                            class="hover-underline">Stock market in last week:
                                                            "The strength of bulls"</a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/assets/img/latest/7.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        lifestyle
                                                    </div>
                                                    <h5 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"
                                                            class="hover-underline">Stock market in last week:
                                                            "The strength of bulls"</a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item border-0">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/assets/img/latest/8.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        lifestyle
                                                    </div>
                                                    <h5 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"
                                                            class="hover-underline">Helm Extract Infuse cream,
                                                            1000mg Full spectrum</a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="tc-post-grid-default border-1 border-bottom brd-gray pb-10">
                                <div class="item">
                                    <div class="img img-cover th-200">
                                        <img src="client/assets/img/latest/2.png" alt="">
                                    </div>
                                    <div class="content pt-20">
                                        <a href="home-default.html#"
                                            class="news-cat color-999 fsz-13px text-uppercase mb-10">travel</a>
                                        <h5 class="title ltspc--1 mb-10"><a href="page-single-post-creative.html">Fact
                                                of Camel in Dubai</a></h5>
                                        <div class="text color-666">
                                            Crime rates on trains and buses are up in some of the nation’s biggest [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-20">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec
                                                        25,
                                                        2022</a>
                                                </li>
                                                <li class="comment">
                                                    <a href="home-default.html#"><i class="la la-comment me-2"></i> 8 </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-15">
                                <span class="fsz-12px color-999 text-capitalize fst-italic">Related Post</span>
                                <a href="page-single-post-creative.html" class="d-flex my-3">
                                    <span class="icon-6 rounded-circle bg-dark me-3 flex-shrink-0 op-4 mt-10"></span>
                                    <h6 class="fsz-16px">
                                        Top 10 Destinations not to be missed this summer
                                    </h6>
                                </a>
                                <a href="page-single-post-creative.html" class="d-flex my-3">
                                    <span class="icon-6 rounded-circle bg-dark me-3 flex-shrink-0 op-4 mt-10"></span>
                                    <h6 class="fsz-16px">
                                        Travel experience Switzerland self-sufficient in 4D3N
                                    </h6>
                                </a>
                                <a href="page-single-post-creative.html" class="d-flex my-3">
                                    <span class="icon-6 rounded-circle bg-dark me-3 flex-shrink-0 op-4 mt-10"></span>
                                    <h6 class="fsz-16px">
                                        Discovery Devon island, Canada
                                    </h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end Latest news ====== -->
        <!-- ====== start columnist ====== -->
        <section class="tc-columnist-style1">
            <div class="container">
                <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                    <p class="color-000 text-uppercase mb-40 ltspc-1 lh-1">top columnist <i
                            class="la la-angle-right ms-1"></i></p>
                    <div class="columnist-slider1 tc-slider-style1">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="columnist-card d-flex align-items-center">
                                        <div
                                            class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                            <img src="client/assets/img/colums/1.png" alt="">
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
                                <div class="swiper-slide">
                                    <div class="columnist-card d-flex align-items-center">
                                        <div
                                            class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                            <img src="client/assets/img/colums/2.png" alt="">
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
                                <div class="swiper-slide">
                                    <div class="columnist-card d-flex align-items-center">
                                        <div
                                            class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                            <img src="client/assets/img/colums/3.png" alt="">
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
                                <div class="swiper-slide">
                                    <div class="columnist-card d-flex align-items-center">
                                        <div
                                            class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                            <img src="client/assets/img/colums/2.png" alt="">
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
                            </div>
                        </div>
                        <!-- arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end columnist ====== -->

        <!-- ====== start another-news ====== -->
        <section class="another-news pt-50 pb-50 border-1 border-top brd-gray">
            <div class="container">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-4">
                            <p class="color-000 text-uppercase mb-30 ltspc-1"><a href="page-blog.html">Sport</a> <i
                                    class="la la-angle-right ms-1"></i></p>
                            <div class="row">
                                <div class="col-12 border-1 border-end brd-gray">
                                    <div class="tc-post-grid-default">
                                        <div class="item">
                                            <div class="img img-cover th-250">
                                                <img src="client/assets/img/another_news/1.png" alt="">
                                            </div>
                                            <div class="content pt-20">
                                                <a href="home-default.html#"
                                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">sport</a>
                                                <h4 class="title ltspc--1 mb-10">
                                                    <a href="page-single-post-creative.html">
                                                        America's track and field team won the 2022 olympics?
                                                    </a>
                                                </h4>
                                                <div class="text color-666">
                                                    Crime rates on trains and buses are up in some of the nation’s
                                                    biggest [...]
                                                </div>
                                                <div class="meta-bot lh-1 mt-20">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i
                                                                    class="la la-calendar me-2"></i>
                                                                Dec 14,
                                                                2022</a>
                                                        </li>
                                                        <li class="comment">
                                                            <a href="home-default.html#"><i
                                                                    class="la la-comment me-2"></i>
                                                                7</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tc-post-list-style2">
                                        <div class="items">
                                            <a href="page-single-post-creative.html"
                                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15 brd-gray">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-4">
                                                        <div class="img th-70 img-cover">
                                                            <img src="client/assets/img/another_news/2.png"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">sport</small>
                                                            <h5 class="title ltspc--1">
                                                                How’s Ameican Football Ball created out?
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="page-single-post-creative.html"
                                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 brd-gray">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-4">
                                                        <div class="img th-70 img-cover">
                                                            <img src="client/assets/img/another_news/3.png"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">sport</small>
                                                            <h5 class="title ltspc--1">
                                                                Daniel share experience ski on Everest
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <p class="color-000 text-uppercase mb-30 ltspc-1"><a href="page-blog.html">Entertaiment</a> <i
                                    class="la la-angle-right ms-1"></i></p>
                            <div class="row">
                                <div class="col-12 border-1 border-end brd-gray">
                                    <div class="tc-post-grid-default">
                                        <div class="item">
                                            <div class="img img-cover th-250">
                                                <img src="client/assets/img/another_news/4.png" alt="">
                                            </div>
                                            <div class="content pt-20">
                                                <a href="home-default.html#"
                                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">Entertaiment</a>
                                                <h4 class="title ltspc--1 mb-10">
                                                    <a href="page-single-post-creative.html">
                                                        Logan Cee's Best Contemporary Art Works
                                                    </a>
                                                </h4>
                                                <div class="text color-666">
                                                    Crime rates on trains and buses are up in some of the nation’s
                                                    biggest [...]
                                                </div>
                                                <div class="meta-bot lh-1 mt-20">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i
                                                                    class="la la-calendar me-2"></i>
                                                                Dec 14,
                                                                2022</a>
                                                        </li>
                                                        <li class="comment">
                                                            <a href="home-default.html#"><i
                                                                    class="la la-comment me-2"></i>
                                                                7</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tc-post-list-style2">
                                        <div class="items">
                                            <a href="page-single-post-creative.html"
                                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15 brd-gray">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-4">
                                                        <div class="img th-70 img-cover">
                                                            <img src="client/assets/img/another_news/5.png"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">entertaiment</small>
                                                            <h5 class="title ltspc--1">
                                                                Netflix change their policy for package family
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="page-single-post-creative.html"
                                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 brd-gray">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-4">
                                                        <div class="img th-70 img-cover">
                                                            <img src="client/assets/img/another_news/6.png"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">entertaiment</small>
                                                            <h5 class="title ltspc--1">
                                                                Buy black vinyl record at Festival Oldschool market
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <p class="color-000 text-uppercase mb-30 ltspc-1"><a href="page-blog.html">Travel</a> <i
                                    class="la la-angle-right ms-1"></i></p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="tc-post-grid-default">
                                        <div class="item">
                                            <div class="img img-cover th-250">
                                                <img src="client/assets/img/another_news/7.png" alt="">
                                            </div>
                                            <div class="content pt-20">
                                                <a href="home-default.html#"
                                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">Travel</a>
                                                <h4 class="title ltspc--1 mb-10">
                                                    <a href="page-single-post-creative.html">
                                                        Top 10 Most beautiful hot springs in the world
                                                    </a>
                                                </h4>
                                                <div class="text color-666">
                                                    Crime rates on trains and buses are up in some of the nation’s
                                                    biggest [...]
                                                </div>
                                                <div class="meta-bot lh-1 mt-20">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i
                                                                    class="la la-calendar me-2"></i>
                                                                Dec 14,
                                                                2022</a>
                                                        </li>
                                                        <li class="comment">
                                                            <a href="home-default.html#"><i
                                                                    class="la la-comment me-2"></i>
                                                                7</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tc-post-list-style2">
                                        <div class="items">
                                            <a href="page-single-post-creative.html"
                                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15 brd-gray">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-4">
                                                        <div class="img th-70 img-cover">
                                                            <img src="client/assets/img/another_news/8.png"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Travel</small>
                                                            <h5 class="title ltspc--1">
                                                                Experience in applying for a visa card for newcomers
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="page-single-post-creative.html"
                                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 brd-gray">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-4">
                                                        <div class="img th-70 img-cover">
                                                            <img src="client/assets/img/another_news/9.png"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Travel</small>
                                                            <h5 class="title ltspc--1">
                                                                Release yourself on the sea and get the vibe chill
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end another-news ====== -->

        <!-- ====== start download ====== -->
        <section class="tc-download-style1 pb-50">
            <div class="container">
                <div class="content">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="info">
                                <strong class="title">Download Newzin App</strong>
                                <div class="text">
                                    Easy to update latest news, daily podcast and everything in your hand
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="img">
                                <a href="home-default.html#">
                                    <img src="client/assets/img/apple1.png" alt="">
                                </a>
                                <a href="home-default.html#">
                                    <img src="client/assets/img/android1.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end download ====== -->

       
        

    </main>
@endsection
