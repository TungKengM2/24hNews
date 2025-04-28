@extends('website.layouts.master')

@section('content')
    <style>
        .hr-section {
            background-color: #f9f9f9;
            padding: 20px 0;
        }

        .hr-section .title a:hover {
            color: #0056b3;
        }
    </style>
    <main>
        <section class="tc-post-title-style1 py-4  border-bottom">
            <div class="container tc-post-title-style1">
                <div class="row align-items-center tc-post-title-style1">
                    <div class="col-lg-8">
                        <h4 class="mb-2 fw-bold">{{ $tag->name }}</h4>
                        <p class=" fw-semibold mb-0">{{ 'Khám phá các bài viết trong thẻ này' }}</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="#">Tag</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $tag->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>




        @if ($highlightedArticle->count())
            <!-- ====== start features posts ====== -->
            <section class="features-posts pt-50 pb-50 bg-gray1">
                <div class="container">
                    <div class="">
                        <div class="row">
                            @foreach ($highlightedArticle as $key => $highlightedArticles)
                                <div class="col-lg-6 {{ $key == 0 ? 'border-1 border-end brd-gray mb-5 mb-lg-0' : '' }}">
                                    <div class="tc-post-overlay-default mb-30 mb-lg-0">
                                        <div class="img th-600 img-cover">
                                            <a
                                                href="{{ route('articles.article', ['slug' => $highlightedArticles->slug]) }}">
                                                <img src="{{ $highlightedArticles->thumbnail_url
                                                    ? asset('storage/' . $highlightedArticles->thumbnail_url)
                                                    : asset('images/default-thumbnail.jpg') }}"
                                                    alt="{{ $highlightedArticles->title ?? 'Ảnh bài viết' }}"
                                                    class="img-fluid">
                                            </a>
                                            @if (!empty($highlightedArticles->category))
                                                <div class="tags">
                                                    <a href="#">
                                                        {{ $highlightedArticles->category->name }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="content ps-30 pe-30 pb-30">
                                            <h2 class="title mb-20">
                                                <a
                                                    href="{{ route('articles.article', ['slug' => $highlightedArticles->slug]) }}">
                                                    {{ $highlightedArticles->title }}
                                                </a>
                                            </h2>
                                            <div class="text">
                                                {{ Str::limit($highlightedArticles->preview_content ?? strip_tags($highlightedArticles->content), 180) }}
                                            </div>
                                            <div class="meta-bot lh-1 mt-40">
                                                <ul class="d-flex">
                                                    <li class="date me-5">
                                                        <i class="la la-calendar me-2"></i>
                                                        {{ optional($highlightedArticles->created_at)->translatedFormat('d \t\há\n\g m, Y') }}
                                                    </li>
                                                    @if (!empty($highlightedArticles->author))
                                                        <li class="author me-5">
                                                            <a
                                                                href="{{ route('website.profileAuth', ['id' => $highlightedArticles->author->user_id]) }}">
                                                                <i class="la la-user me-2"></i>
                                                                Bởi <span class="color-white">
                                                                    {{ $highlightedArticles->author->username }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li class="comment">
                                                        <a
                                                            href="{{ route('articles.article', ['slug' => $highlightedArticles->slug]) }}">
                                                            <i class="la la-comment me-2"></i>
                                                            {{ $highlightedArticles->comments_count ?? 0 }} Bình luận
                                                        </a>
                                                    </li>
                                                    <li class="views ms-5"> <!-- Thêm ms-5 để tạo khoảng cách bên trái -->
                                                        <a
                                                            href="{{ route('articles.article', ['slug' => $highlightedArticles->slug]) }}">
                                                            <i class="la la-eye me-2"></i>
                                                            {{ $highlightedArticles->views ?? 0 }} Lượt xem
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
                </div>
            </section>
            <!-- ====== end features posts ====== -->
        @else
            <section class="features-posts pt-50 pb-50 bg-gray1">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">Chưa có bài viết nổi bật trong tuần.</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- ====== start popular posts ====== -->
        <section class="tc-popular-posts-blog">
            <div class="container">
                <div class="content pt-50 pb-50 border-1 border-bottom brd-gray">
                    <p class="color-000 text-uppercase mb-30 ltspc-1"> Bài Viết Nổi Bật </p>
                    <!-- Kiểm tra nếu có bài viết -->
                    @if ($highlightedArticleByViews->isNotEmpty())
                        <div class="tc-post-grid-default">
                            <div class="tc-popular-posts-blog-slider9 tc-slider-style1">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach ($highlightedArticleByViews as $article)
                                            <div class="swiper-slide">
                                                <div class="item">
                                                    <div class="img img-cover th-180">
                                                        <img src="{{ $article->thumbnail_url ? asset('storage/' . $article->thumbnail_url) : asset('images/default-thumbnail.jpg') }}"
                                                            alt="{{ $article->title ?? 'Ảnh bài viết' }}"
                                                            class="img-fluid">
                                                        @if (!empty($article->is_video) && $article->is_video)
                                                            <a href="{{ $article->video_url }}" data-lity=""
                                                                class="video_icon icon-50 border-2">
                                                                <i class="ion-play fsz-20px"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="content pt-20">
                                                        @if (!empty($article->category))
                                                            <a href="#"
                                                                class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                                {{ $article->category->name }}
                                                            </a>
                                                        @endif
                                                        <h4 class="title ltspc--1 mb-10">
                                                            <a
                                                                href="{{ !empty($article->slug) ? route('articles.article', $article->slug) : '#' }}">
                                                                {{ $article->title ?? 'Không có tiêu đề' }}
                                                            </a>
                                                        </h4>
                                                        <div class="text color-666">
                                                            {{ Str::limit($article->description ?? '', 100) }}
                                                        </div>
                                                        <div class="meta-bot lh-1 mt-20">
                                                            <ul class="d-flex">
                                                                <li class="date me-5">
                                                                    <a
                                                                        href="{{ !empty($article->slug) ? route('articles.article', $article->slug) : '#' }}">
                                                                        <i class="la la-calendar me-2"></i>
                                                                        {{ optional($article->created_at)->translatedFormat('d \t\há\n\g m, Y') ?? '' }}
                                                                    </a>
                                                                </li>
                                                                <li class="comment">
                                                                    <a
                                                                        href="{{ !empty($article->slug) ? route('articles.article', $article->slug) : '#' }}">
                                                                        <i class="la la-comment me-2"></i>
                                                                        {{ $article->comments_count ?? 0 }}
                                                                    </a>
                                                                </li>
                                                                <li class="views ms-5">
                                                                    <!-- Thêm ms-5 để tạo khoảng cách bên trái -->
                                                                    <a
                                                                        href="{{ !empty($article->slug) ? route('articles.article', $article->slug) : '#' }}">
                                                                        <i class="la la-eye me-2"></i>
                                                                        {{ $article->views ?? 0 }} Lượt xem
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
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    @else
                        <section class="features-posts pt-50 pb-50 bg-gray1">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">Hiện tại không có bài viết nổi bật.</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif


                </div>

                <div class="content-widgets pt-50 pb-50">
                    <div class="row">
                        <div class="col-lg-9">
                            {{-- Bài viết mới nhất --}}
                            @if ($latestArticles->isNotEmpty())
                                <div class="tc-post-list-style3">
                                    <div class="items">
                                        @foreach ($latestArticles as $article)
                                            <div class="item">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="img th-230 img-cover overflow-hidden">
                                                            <img src="{{ $article->thumbnail_url ? asset('storage/' . $article->thumbnail_url) : asset('images/default-thumbnail.jpg') }}"
                                                                alt="{{ $article->title }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="content mt-20 mt-lg-0">
                                                            <a href="{{ route('articles.article', $article->slug) }}"
                                                                class="color-999 fsz-13px text-uppercase mb-10">
                                                                {{ $article->category->name ?? 'Sport' }}
                                                            </a>
                                                            <h4 class="title mb-15">
                                                                <a
                                                                    href="{{ route('articles.article', $article->slug) }}">{{ $article->title }}</a>
                                                            </h4>
                                                            <div class="text color-666">
                                                                {{ Str::limit($article->excerpt, 100, '...') }}
                                                            </div>
                                                            <div class="meta-bot fsz-13px color-666">
                                                                <ul class="d-flex">
                                                                    <li class="date me-5">
                                                                        <a
                                                                            href="{{ route('articles.article', $article->slug) }}">
                                                                            <i
                                                                                class="la la-calendar me-2"></i>{{ $article->created_at->translatedFormat('d \t\há\n\g m, Y') }}
                                                                        </a>
                                                                    </li>
                                                                    <li class="author me-5">
                                                                        <a
                                                                            href="{{ route('website.profileAuth', ['id' => $article->author->user_id]) }}">
                                                                            <i class="la la-user me-2"></i>Bởi <span
                                                                                class="color-000">{{ $article->author->username ?? 'Unknown' }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="comment">
                                                                        <a
                                                                            href="{{ route('articles.article', $article->slug) }}">
                                                                            <i
                                                                                class="la la-comment me-2"></i>{{ $article->comments_count }}
                                                                            Bình Luận
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <section class="features-posts pt-50 pb-50 bg-gray1">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="text-center">Hiện tại không có bài viết hiển thị.</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endif

                            {{-- Một bài viết nổi bật --}}
                            @if ($singleLatestArticle->isNotEmpty())
                                <div class="tc-post-grid-default pb-40">
                                    @foreach ($singleLatestArticle as $article)
                                        <div class="item pt-30">
                                            <div class="img img-cover th-575">
                                                <img src="{{ $article->thumbnail_url ? asset('storage/' . $article->thumbnail_url) : asset('images/default-thumbnail.jpg') }}"
                                                    alt="{{ $article->title }}">
                                            </div>
                                            <div class="content pt-30">
                                                <a href="{{ route('articles.article', $article->slug) }}"
                                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                    {{ $article->category->name ?? 'Uncategorized' }}
                                                </a>
                                                <h2 class="title mb-20">
                                                    <a href="{{ route('articles.article', $article->slug) }}"
                                                        class="fsz-35px lh-3">
                                                        {{ $article->title }}
                                                    </a>
                                                </h2>
                                                <div class="text color-666">
                                                    {{ Str::limit($article->excerpt, 150, '...') }}
                                                </div>
                                                <div class="meta-bot lh-1 mt-40">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="{{ route('articles.article', $article->slug) }}">
                                                                <i class="la la-calendar me-2"></i>
                                                                {{ $article->created_at?->translatedFormat('d \t\há\n\g m, Y') }}
                                                            </a>
                                                        </li>
                                                        <li class="author me-5">
                                                            <a
                                                                href="{{ route('website.profileAuth', ['id' => $article->author->user_id]) }}">
                                                                <i class="la la-user me-2"></i>by <span
                                                                    class="color-000">{{ $article->author->username }}</span>
                                                            </a>
                                                        </li>
                                                        <li class="comment me-5">
                                                            <a href="{{ route('articles.article', $article->slug) }}">
                                                                <i
                                                                    class="la la-comment me-2"></i>{{ $article->comments_count }}
                                                                Bình Luận
                                                            </a>
                                                        </li>
                                                        <li class="views">
                                                            <a href="{{ route('articles.article', $article->slug) }}">
                                                                <i class="la la-eye me-2"></i>{{ $article->views ?? 0 }}
                                                                Lượt Xem
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <section class="features-posts pt-50 pb-50 bg-gray1">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="text-center">Hiện tại không có bài viết hiển thị.</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endif

                            {{-- Banner --}}
                            <div class="banner20 border-1 border-bottom brd-gray pt-20 pb-20"></div>

                            {{-- Bài viết phân trang --}}
                            @if ($paginatedArticles->isNotEmpty())
                                <div class="tc-post-list-style3">
                                    <div class="items">
                                        @foreach ($paginatedArticles as $article)
                                            <div class="item mt-30">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="img th-230 img-cover overflow-hidden">
                                                            <img src="{{ $article->thumbnail_url ? asset('storage/' . $article->thumbnail_url) : asset('images/default-thumbnail.jpg') }}"
                                                                alt="{{ $article->title }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="content mt-20 mt-lg-0">
                                                            <a href="{{ route('articles.article', $article->slug) }}"
                                                                class="color-999 fsz-13px text-uppercase mb-10">
                                                                {{ $article->category->name }}
                                                            </a>
                                                            <h4 class="title fw-bold">
                                                                <a href="{{ route('articles.article', $article->slug) }}"
                                                                    class="hover-underline">
                                                                    {{ $article->title }}
                                                                </a>
                                                            </h4>
                                                            <div class="text color-666 mt-20">
                                                                {{ Str::limit($article->description, 150) }}
                                                            </div>
                                                            <div class="meta-bot fsz-13px color-666">
                                                                <ul class="d-flex">
                                                                    <li class="date me-5">
                                                                        <a
                                                                            href="{{ route('articles.article', $article->slug) }}">
                                                                            <i
                                                                                class="la la-calendar me-2"></i>{{ $article->created_at?->translatedFormat('d \t\há\n\g m, Y') }}
                                                                        </a>
                                                                    </li>
                                                                    <li class="author me-5">
                                                                        <a
                                                                            href="{{ route('website.profileAuth', ['id' => $article->author->user_id]) }}">
                                                                            <i class="la la-user me-2"></i>by <span
                                                                                class="color-000">{{ $article->author->username }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="comment">
                                                                        <a
                                                                            href="{{ route('articles.article', $article->slug) }}">
                                                                            <i
                                                                                class="la la-comment me-2"></i>{{ $article->comments_count }}
                                                                            Bình Luận
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Phân trang --}}
                                    <div class="pagination style-1 color-main justify-content-center mt-60">
                                        {{ $paginatedArticles->links() }}
                                    </div>
                                </div>
                            @else
                                <section class="features-posts pt-50 pb-50 bg-gray1">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="text-center">Hiện tại không có bài viết hiển thị.</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endif


                        </div>
                        <div class="col-lg-3">
                            <div class="widgets-sticky mt-5 mt-lg-0">
                                <!-- widget-trends -->
                                @php
                                    $posts = $highlightedArticleLast30Days;
                                @endphp

                                <div class="tc-trending-news-style5 border border-1 brd-gray mb-40">
                                    <p class="color-000 text-uppercase p-15">Bài Viết Xu Hướng</p>

                                    @if ($posts->isNotEmpty())
                                        {{-- 1. Bài viết nổi bật nhất --}}
                                        @php $first = $posts->first() @endphp
                                        <div class="tc-post-overlay-default">
                                            <div class="img th-200 img-cover">
                                                <img src="{{ $first->thumbnail_url ? asset('storage/' . $first->thumbnail_url) : asset('images/default-thumbnail.jpg') }}"
                                                    alt="{{ $first->title }}">
                                            </div>
                                            <div class="content ps-20 pe-20 pb-20 text-white">
                                                <a href="{{ route('articles.show', $first->slug) }}"
                                                    class="text-uppercase fsz-13px mb-1">
                                                    {{ $first->category->name }}
                                                </a>
                                                <h4 class="title">
                                                    <a href="{{ route('articles.show', $first->slug) }}">
                                                        {{ Str::limit($first->title, 60) }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>

                                        {{-- 2. Danh sách phụ --}}
                                        <div class="tc-post-list-style1">
                                            <div class="items px-4 py-2" id="trending-list">
                                                @foreach ($posts->skip(1) as $idx => $article)
                                                    <div class="item trending-item"
                                                        @if ($idx >= 5) style="display:none" @endif>
                                                        <h2 class="num">{{ $idx + 1 }}</h2>
                                                        <div class="content">
                                                            <a href="{{ route('articles.article', $article->slug) }}"
                                                                class="color-999 fsz-12px text-uppercase mb-1">
                                                                {{ $article->category->name }}
                                                            </a>
                                                            <h6 class="title fsz-16px fw-bold ltspc--1 hover-main">
                                                                <a href="{{ route('articles.article', $article->slug) }}">
                                                                    {{ Str::limit($article->title, 50) }}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    @else
                                        <p class="text-center color-666">Hiện chưa có bài viết xu hướng nào.</p>
                                    @endif
                                </div>





                                <!-- widget tags -->
                                <div class="tc-widget-tags-style5 mb-40">
                                    <p class="color-000 text-uppercase mb-30">Tags Nổi Bật </p>
                                    <div class="tags-content">
                                        @foreach ($tags as $tag)
                                            <a href="{{ route('tags.shows', ['tag' => $tag->tag_id]) }}"
                                                class="  btn btn-sm ">{{ $tag->name }}
                                                ({{ $tag->published_articles_count }})
                                            </a>
                                        @endforeach

                                    </div>
                                </div>
                                <!-- end widget tags -->

                                <!-- widget webStories -->
                                <div class="tc-widget-webStories-style5">
                                    <div class="card-header bg-white border-bottom border-primary border-3">
                                        <p class="color-000 text-uppercase mb-30">Bài Viết Đã Xem </p>
                                    </div>
                                    <div class=" list-group-flush">
                                        @if (isset($recentArticles) && $recentArticles->count() > 0)
                                            @foreach ($recentArticles as $recentArticle)
                                                <a href="{{ route('articles.article', $recentArticle->slug) }}"
                                                    class="list-group-item list-group-item-action d-flex align-items-center p-3">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            {{ Str::limit($recentArticle->title, 100) }}</h6>
                                                        <small class="text-muted">
                                                            <i class="la la-calendar me-1"></i>
                                                            {{ $recentArticle->created_at->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                            <div class="list-group-item">Không có bài viết gần đây.</div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end popular posts ====== -->












    </main>
@endsection
