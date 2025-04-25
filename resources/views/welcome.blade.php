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
        <!-- ====== end tin tức nổi bật ====== -->



        <!-- ====== start columnist ====== -->
        @if(isset($topAuthors) && !$topAuthors->isEmpty())
        <section class="tc-columnist-style1">
            <div class="container">
                <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                    <p class="color-000 text-uppercase mb-40 ltspc-1 lh-1">Tác giả nổi bật </p>
                    <div class="row">
                        @foreach($topAuthors as $authorData)
                            <div class="col-lg-4 col-md-4 mb-4">
                                <div class="columnist-card d-flex align-items-center">
                                    <div class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                        <a href="{{ route('website.profileAuth', ['id' => $authorData['author']->user_id]) }}">
                                            <img src="{{ $authorData['author']->image ? asset('storage/' . $authorData['author']->image) : asset('/images/default-avatar.png') }}"
                                                alt="{{ $authorData['author']->username }}">
                                        </a>
                                    </div>
                                    <div class="info">
                                        <h6 class="name fsz-20px mb-10">
                                            <a href="{{ route('website.profileAuth', ['id' => $authorData['author']->user_id]) }}">
                                                {{ $authorData['author']->name ?? $authorData['author']->username }}
                                            </a>
                                        </h6>
                                        <div class="rating mb-1">
                                            <span class="text-warning">
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
                                                <span class="text-muted ms-2">({{ number_format($authorData['rating'], 1) }})</span>
                                            </span>
                                        </div>
                                        <div class="jop-title">
                                            <small class="fsz-13px color-999">Lĩnh vực chính</small>
                                            <p class="fsz-13px text-uppercase">
                                                @if(isset($authorData['specializes_slug']) && $authorData['specializes_slug'])
                                                    <a href="{{ route('client.category.author.show', ['categorySlug' => $authorData['specializes_slug'], 'authorId' => $authorData['author']->user_id]) }}" class="text-primary">
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
                <div class="section-content">
                    <div class="row align-items-stretch">
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
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{-- // ènd top 3 bài viết nhiều lượt xem --}}
                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 h-110">
                            <div class="tc-post-list-style1 bg-white p-3 rounded shadow h-100">
                                <div class="tc-post-title-style1 mb-3">
                                    <h5 class=" fw-bold">Top Bài Viết Thảo Luận</h5>
                                </div>
                                {{-- // top 4 bài viết nhiều Bluan nhất 30 ngày trở lại  --}}
                                @if ($trendingPosts->isNotEmpty())
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
                                @else
                                    <p class="text-center text-muted">Chưa có bài viết nào.</p>
                                @endif
                                {{-- // top 4 bài viết nhiều Bluan nhất 30 ngày trở lại  --}}
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
                                    <div class="img img-cover th-275">
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
                                            Xem chi tiết <i class="la la-angle-right mt-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end tin tức có thể quan tâm ====== -->


        <!-- ====== start Latest news ====== -->
        <section class="tc-latest-news-style1">
            <div class="container">
                <div class="section-content  pb-50 border-bottom border-1 brd-gray">
                    <p class="color-000 text-uppercase mb-30 ltspc-1 font-bold ">
                    <h3>Tin Tức Mới Nhất</h3>{{--  <i class="la la-angle-right "></i> --}}
                    </p>
                    <div class="row">
                        <div class="col-lg-5 border-end brd-gray border-1">
                            <div class="tc-post-grid-default">
                                <div class="item">
                                    <div class="img img-cover th-330">
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/1.png"
                                            alt="">

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
                                                        14, 2022</a>
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
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/3.png"
                                                        alt="">
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
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/4.png"
                                                        alt="">
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
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/5.png"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        lifestyle</div>
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
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/6.png"
                                                        alt="">
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
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/7.png"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        lifestyle</div>
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
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/8.png"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-1">
                                                        lifestyle</div>
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
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/2.png"
                                            alt="">
                                    </div>
                                    <div class="content pt-20">

                                        <h5 class="title ltspc--1 mb-10"> <a href="page-single-post-creative.html">Fact
                                                of Camel in Dubai</a> </h5>
                                        <div class="text color-666">
                                            Crime rates on trains and buses are up in some of the nation's biggest [...]
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-grid-default border-1 border-bottom brd-gray pb-10">
                                <div class="item">
                                    <div class="img img-cover th-200">
                                        <img src="https://newzin-html.themescamp.com/assets/img/must_read/1.png"
                                            alt="">
                                    </div>
                                    <div class="content pt-20">

                                        <h5 class="title ltspc--1 mb-10"> <a href="page-single-post-creative.html">Fact
                                                of Camel in Dubai</a> </h5>
                                        <div class="text color-666">
                                            Crime rates on trains and buses are up in some of the nation's biggest [...]
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end Latest news ====== -->
        <!-- ====== start trending posts ====== -->
        <section class="">
            <div class="container bg-white">
                <div class="content bg-white">
                    <div class="section-title-style2 mb-30 ">
                        <h3>Bài viết thịnh hành tuần này </h3>
                    </div>
                    <div class="tc-trends-news-slider2">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/trend/5.png"
                                                alt="">
                                            <span class="num">1</span>
                                        </div>
                                        <div class="info">
                                            <div class="tags mt-20">
                                                <a href="home-technology.html#"
                                                    class="bg-primary text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">Giáo
                                                    Dục</a>
                                            </div>
                                            <h4 class="title mt-20">
                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                    The zappi EV Charger, Best charger for future
                                                </a>
                                            </h4>
                                            <div class="meta-bot lh-1 text-capitalize color-666 fsz-13px mt-30">
                                                <ul class="d-flex">
                                                    <li class="date me-4">
                                                        <a href="home-technology.html#"><i
                                                                class="la la-calendar me-1"></i> Dec 14,
                                                            2022</a>
                                                    </li>
                                                    <li class="comment">
                                                        <a href="home-technology.html#"><i class="la la-comment me-1"></i>
                                                            7 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/trend/6.png"
                                                alt="">
                                            <span class="num">2</span>
                                        </div>
                                        <div class="info">
                                            <div class="tags mt-20">
                                                <a href="home-technology.html#"
                                                    class="bg-orange text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">Lối
                                                    Sống</a>
                                            </div>
                                            <h4 class="title mt-20">
                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                    Netflix change their policy for package faminly
                                                </a>
                                            </h4>
                                            <div class="meta-bot lh-1 text-capitalize color-666 fsz-13px mt-30">
                                                <ul class="d-flex">
                                                    <li class="date me-4">
                                                        <a href="home-technology.html#"><i
                                                                class="la la-calendar me-1"></i> Dec 14,
                                                            2022</a>
                                                    </li>
                                                    <li class="comment">
                                                        <a href="home-technology.html#"><i class="la la-comment me-1"></i>
                                                            1 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/trend/7.png"
                                                alt="">
                                            <span class="num">3</span>
                                        </div>
                                        <div class="info">
                                            <div class="tags mt-20">
                                                <a href="home-technology.html#"
                                                    class="bg-cyan text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">Kinh
                                                    Doanh</a>
                                                <a href="home-technology.html#"
                                                    class="bg-primary text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">Công
                                                    Nghệ</a>
                                            </div>
                                            <h4 class="title mt-20">
                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                    VR Oculus 3.0 Next gen, Future of AI
                                                </a>
                                            </h4>
                                            <div class="meta-bot lh-1 text-capitalize color-666 fsz-13px mt-30">
                                                <ul class="d-flex">
                                                    <li class="date me-4">
                                                        <a href="home-technology.html#"><i
                                                                class="la la-calendar me-1"></i> Dec 14,
                                                            2022</a>
                                                    </li>
                                                    <li class="comment">
                                                        <a href="home-technology.html#"><i class="la la-comment me-1"></i>
                                                            71 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/trend/8.png"
                                                alt="">
                                            <span class="num">4</span>
                                        </div>
                                        <div class="info">
                                            <div class="tags mt-20">
                                                <a href="home-technology.html#"
                                                    class="bg-purple text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">giải
                                                    trí</a>
                                            </div>
                                            <h4 class="title mt-20">
                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                    Become Backend Dev at Google Studio
                                                </a>
                                            </h4>
                                            <div class="meta-bot lh-1 text-capitalize color-666 fsz-13px mt-30">
                                                <ul class="d-flex">
                                                    <li class="date me-4">
                                                        <a href="home-technology.html#"><i
                                                                class="la la-calendar me-1"></i> Dec 14,
                                                            2022</a>
                                                    </li>
                                                    <li class="comment">
                                                        <a href="home-technology.html#"><i class="la la-comment me-1"></i>
                                                            4 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/trend/9.png"
                                                alt="">
                                            <span class="num">5</span>
                                        </div>
                                        <div class="info">
                                            <div class="tags mt-20">
                                                <a href="home-technology.html#"
                                                    class="bg-cyan text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">Chính
                                                    Trị</a>
                                                <a href="home-technology.html#"
                                                    class="bg-primary text-white py-1 px-3 rounded-pill fsz-12px text-uppercase me-2">Pháp
                                                    Luật</a>
                                            </div>
                                            <h4 class="title mt-20">
                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                    Next gen, Future of ropots whats new
                                                </a>
                                            </h4>
                                            <div class="meta-bot lh-1 text-capitalize color-666 fsz-13px mt-30">
                                                <ul class="d-flex">
                                                    <li class="date me-4">
                                                        <a href="home-technology.html#"><i
                                                                class="la la-calendar me-1"></i> Dec 14,
                                                            2022</a>
                                                    </li>
                                                    <li class="comment">
                                                        <a href="home-technology.html#"><i class="la la-comment me-1"></i>
                                                            71 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end trending posts ====== -->

         <!-- ====== start another-news ====== -->
         <section class="another-news pt-50 pb-50 border-1 border-top brd-gray">
            <div class="container">
                <h3 class="mb-10">Danh Mục Hàng Đầu</h3>

                <div class="content">
                    <div class="row">
                        <div class="col-lg-4">
                            <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">Thể Thao</a> <i
                                    class="la la-angle-right ms-1"></i> </p>
                            <div class="row">
                                <div class="col-12 border-1 border-end brd-gray">
                                    <div class="tc-post-grid-default">
                                        <div class="item">
                                            <div class="img img-cover th-250">
                                                <img src="https://newzin-html.themescamp.com/assets/img/another_news/1.png" alt="">
                                            </div>
                                            <div class="content pt-20">
                                                <a href="home-default.html#"
                                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">Thể Thao</a>
                                                <h4 class="title ltspc--1 mb-10">
                                                    <a href="page-single-post-creative.html">
                                                        America's track and field team won the 2022 olympics?
                                                    </a>
                                                </h4>
                                                <div class="text color-666">
                                                    Crime rates on trains and buses are up in some of the nation's
                                                    biggest [...]
                                                </div>
                                                <div class="meta-bot lh-1 mt-20">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                                2022</a>
                                                        </li>
                                                        <li class="comment">
                                                            <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
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
                                                            <img src="https://newzin-html.themescamp.com/assets/img/another_news/2.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Thể Thao</small>
                                                            <h5 class="title ltspc--1">
                                                                How's Ameican Football Ball created out?
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
                                                            <img src="https://newzin-html.themescamp.com/assets/img/another_news/3.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Thể Thao</small>
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
                            <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">Giải Trí</a> <i
                                    class="la la-angle-right ms-1"></i> </p>
                            <div class="row">
                                <div class="col-12 border-1 border-end brd-gray">
                                    <div class="tc-post-grid-default">
                                        <div class="item">
                                            <div class="img img-cover th-250">
                                                <img src="https://newzin-html.themescamp.com/assets/img/another_news/4.png" alt="">
                                            </div>
                                            <div class="content pt-20">
                                                <a href="home-default.html#"
                                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">Giải Trí</a>
                                                <h4 class="title ltspc--1 mb-10">
                                                    <a href="page-single-post-creative.html">
                                                        Logan Cee's Best Contemporary Art Works
                                                    </a>
                                                </h4>
                                                <div class="text color-666">
                                                    Crime rates on trains and buses are up in some of the nation's
                                                    biggest [...]
                                                </div>
                                                <div class="meta-bot lh-1 mt-20">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                                2022</a>
                                                        </li>
                                                        <li class="comment">
                                                            <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
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
                                                            <img src="https://newzin-html.themescamp.com/assets/img/another_news/5.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Giải Trí</small>
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
                                                            <img src="https://newzin-html.themescamp.com/assets/img/another_news/6.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Giải Trí</small>
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
                            <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">Du Lịch</a> <i
                                    class="la la-angle-right ms-1"></i> </p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="tc-post-grid-default">
                                        <div class="item">
                                            <div class="img img-cover th-250">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/7.png" alt="">
                                            </div>
                                            <div class="content pt-20">
                                                <a href="home-default.html#"
                                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">Du Lịch</a>
                                                <h4 class="title ltspc--1 mb-10">
                                                    <a href="page-single-post-creative.html">
                                                        Top 10 Most beautiful hot springs in the world
                                                    </a>
                                                </h4>
                                                <div class="text color-666">
                                                    Crime rates on trains and buses are up in some of the nation's
                                                    biggest [...]
                                                </div>
                                                <div class="meta-bot lh-1 mt-20">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                                2022</a>
                                                        </li>
                                                        <li class="comment">
                                                            <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
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
                                                            <img src="https://newzin-html.themescamp.com/assets/img/another_news/8.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Du Lịch</small>
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
                                                            <img src="https://newzin-html.themescamp.com/assets/img/another_news/9.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <small
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">Du Lịch</small>
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
          <!-- ====== start author-posts ====== -->
          <section class="tc-author-posts pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="posts-side">
                            <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">recently
                                    added</a> <i class="la la-angle-right ms-1"></i></p>

                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item pt-30 pb-30 mt-30 border-1 border-top border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/technology/2.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/technology/3.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/page_author/1.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/page_author/2.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/page_author/3.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/page_author/4.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/page_author/5.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/page_author/6.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-30 border-1 border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/page_author/7.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="page-author.html#">technology</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="page-single-post-creative.html"> Big Title for featured
                                                            post with double line and
                                                            more text </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-user me-2"></i> by Admin
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="page-author.html#"><i
                                                                        class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="tc-side-widgets mt-5 mt-lg-0">


                            <!-- popular posts -->
                            <div class="tc-widget-popular-style1">
                                <p class="color-000 text-uppercase mb-20 ltspc-1"> popular posts </p>
                                <div class="main-card">
                                    <div class="img th-300 img-cover">
                                        <img src="https://newzin-html.themescamp.com/assets/img/wid_popular/1.png" alt="">
                                        <div class="tags">
                                            <a href="page-author.html#">business</a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">
                                            <a href="page-single-post-creative.html">Big Title for featured post with
                                                double</a>
                                        </h4>
                                        <div class="meta-bot">
                                            <ul class="d-flex">
                                                <li class="date me-4">
                                                    <a href="page-author.html#"><i class="la la-calendar me-1"></i> Dec
                                                        14, 2022</a>
                                                </li>
                                                <li class="comment">
                                                    <a href="page-author.html#"><i class="la la-comment me-1"></i> 55
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tc-widget-popular-list">
                                    <a href="page-single-post-creative.html" class="item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/wid_popular/2.png" alt="">
                                        </div>
                                        <div class="info">
                                            <h6 class="title">
                                                Joe Biden did not participate in the war
                                            </h6>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html" class="item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/wid_popular/3.png" alt="">
                                        </div>
                                        <div class="info">
                                            <h6 class="title">
                                                Mindset to Succesful, Become Lion King
                                            </h6>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html" class="item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/wid_popular/4.png" alt="">
                                        </div>
                                        <div class="info">
                                            <h6 class="title">
                                                Experience ballon balls in Turkey
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== End author-posts ====== -->


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
