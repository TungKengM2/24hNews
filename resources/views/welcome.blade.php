@extends('website.layouts.master')

@section('content')
    <main>
        <meta name="csrf-token" content="{{ csrf_token() }}">



        <!-- ====== start breaking news ====== -->
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


        {{-- Bài viết của author đã fl --}}
        <div class="container">
            <div class="tc-technology-style1 pt-50">
                <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">bài viết tác giả bạn quan
                        tâm</a> <i class="la la-angle-right ms-1"></i> </p>

                <div class="tc-post-list-style2">
                    <div class="items">
                        @auth
                            @if ($articlesfollow->isEmpty())
                                <p class="text-center">Bạn chưa follow ai hoặc chưa có bài viết nào!</p>
                            @else
                                @foreach ($articlesfollow as $article)
                                    <div class="item pt-30 pb-30 mt-30 border-1 border-top border-bottom brd-gray">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="img th-200 img-cover">
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                        alt="{{ $article->title }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="content">
                                                    <div class="news-cat color-999 fsz-13px text-uppercase mb-3">
                                                        <a href="#">{{ $article->category->name }}</a>
                                                    </div>
                                                    <h3 class="title ltspc--1">
                                                        <a href="{{ route('articles.article', $article->slug) }}"
                                                            class="item hover-main d-block p-2 text-dark">
                                                            {{ $article->title }}
                                                        </a>
                                                    </h3>
                                                    <div class="meta-bot lh-1 mt-80">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="#"><i class="la la-calendar me-2"></i>
                                                                    {{ $article->created_at->format('M d, Y') }}</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="#"><i class="la la-user me-2"></i> by
                                                                    {{ $article->author->username }}</a>
                                                            </li>
                                                            <li class="views me-5">
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
                            <p class="text-center text-danger">Bạn chưa đăng ký/đăng nhập để theo dõi tác giả.</p>
                        @endauth
                    </div>
                </div>

            </div>
        </div>

        <!-- ====== start trends news ====== -->
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
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>



    </main>
@endsection
