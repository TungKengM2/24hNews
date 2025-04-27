@extends('website.layouts.master')

@section('content')
    <style>
        .tc-blog-nav-search .links a {
            color: #000;
            text-decoration: none;
            margin-right: 15px;
            position: relative;
            padding-bottom: 3px;
        }

        .tc-blog-nav-search .links a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 1px;
            background-color: #000;
            transition: width 0.3s;
        }

        .tc-blog-nav-search .links a:hover::after {
            width: 100%;
        }
        
    </style>
    <main>

        <!-- ====== start nav search ====== -->
        <div class="tc-blog-nav-search py-4 border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="info">
                            <h1 class="fw-bold mb-2">{{ $category->name }}</h1>
                            <p class="fw-semibold mb-3">
                                {{ $category->description ?? ($category->parent->description ?? 'Khám phá các bài viết trong danh mục này') }}
                            </p>

                            <div class="links d-flex flex-wrap gap-3">
                                @foreach ($category->children as $child)
                                    <a href="{{ route('client.category.show', ['slug' => $category->slug, 'childSlug' => $child->slug]) }}"
                                        class="text-dark text-decoration-none">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-5">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="#">Danh mục</a></li>

                                @if ($category->parent)
                                    <!-- Nếu là danh mục con thì hiển thị cate cha -->
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('client.category.show', $category->parent->slug) }}">
                                            {{ $category->parent->name }}
                                        </a>
                                    </li>
                                    <!-- Sau đó hiển thị cate con (hiện tại) -->
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $category->name }}
                                    </li>
                                @else
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $category->name }}
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
        <!-- ====== end nav search ====== -->


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
                            <div class="tc-post-list-style3">
                                <div class="items">
                                    <!-- Hiển thị 2 bài viết mới nhất -->
                                    @forelse ($latestArticles as $article)
                                        <div class="item">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="img th-230 img-cover overflow-hidden">
                                                        <img src="{{ $article->thumbnail_url
                                                            ? asset('storage/' . $article->thumbnail_url)
                                                            : asset('images/default-thumbnail.jpg') }}"
                                                            alt="{{ $article->title }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="content mt-20 mt-lg-0">
                                                        <a href="{{ route('articles.article', $article->slug) }}"
                                                            class="color-999 fsz-13px text-uppercase mb-10">{{ $article->category->name ?? 'Sport' }}</a>
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
                                    @empty
                                        <section class="features-posts pt-50 pb-50 bg-gray1">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="text-center">Hiện tại không có bài viết hiển thị.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    @endforelse
                                </div>

                            </div>
                            <div class="tc-post-grid-default pb-40">
                                @forelse($singleLatestArticle as $article)
                                    <div class="item pt-30">
                                        <div class="img img-cover th-575">
                                            <img src="{{ $article->thumbnail_url
                                                ? asset('storage/' . $article->thumbnail_url)
                                                : asset('images/default-thumbnail.jpg') }}"
                                                alt="">
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
                                                            {{ optional($article->created_at)->translatedFormat('d \t\há\n\g m, Y') ?? '' }}

                                                        </a>
                                                    </li>
                                                    <li class="author me-5">
                                                        <a
                                                            href="{{ route('website.profileAuth', ['id' => $article->author->user_id]) }}">
                                                            <i class="la la-user me-2"></i> by <span
                                                                class="color-000">{{ $article->author->username }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="comment me-5">
                                                        <a href="{{ route('articles.article', $article->slug) }}">
                                                            <i class="la la-comment me-2"></i>
                                                            {{ $article->comments_count }} Bình Luận
                                                        </a>
                                                    </li>
                                                    <li class="views">
                                                        <a href="{{ route('articles.article', $article->slug) }}">
                                                            <i class="la la-eye me-2"></i> {{ $article->views ?? 0 }}
                                                            Lượt Xem
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <br>
                                    <section class="features-posts pt-50 pb-50 bg-gray1">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="text-center">Hiện tại không có bài viết hiển thị.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endforelse
                            </div>

                            <!-- ====== start banner20 ====== -->
                            <div class="banner20 border-1  border-bottom brd-gray pt-20 pb-20">

                            </div>

                            <div class="tc-post-list-style3">
                                <div class="items">
                                    @if ($paginatedArticles->isEmpty())
                                        <section class="features-posts pt-50 pb-50 bg-gray1">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="text-center">Hiện tại không có bài viết hiển thị.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    @else
                                        @foreach ($paginatedArticles as $article)
                                            <div class="item mt-30">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="img th-230 img-cover overflow-hidden">
                                                            <img src="{{ $article->thumbnail_url
                                                                ? asset('storage/' . $article->thumbnail_url)
                                                                : asset('images/default-thumbnail.jpg') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="content mt-20 mt-lg-0">
                                                            <a href="page-blog.html#"
                                                                class="color-999 fsz-13px text-uppercase mb-10">{{ $article->category->name }}</a>
                                                            <h4 class="title fw-bold">
                                                                <a href="{{ route('articles.show', $article->slug) }}"
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
                                                                        <a href="page-blog.html#"><i
                                                                                class="la la-calendar me-2"></i>
                                                                            {{ optional($article->created_at)->translatedFormat('d \t\há\n\g m, Y') ?? '' }}
                                                                        </a>
                                                                    </li>
                                                                    <li class="author me-5">
                                                                        <a href="page-blog.html#"><i
                                                                                class="la la-user me-2"></i> by <span
                                                                                class="color-000">{{ $article->author->username }}</span></a>
                                                                    </li>
                                                                    <li class="comment">
                                                                        <a href="page-blog.html#"><i
                                                                                class="la la-comment me-2"></i>
                                                                            {{ $article->comments_count }} Bình Luận</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                                <!-- Phân trang -->
                                <div class="pagination style-1 color-main justify-content-center mt-60">
                                    {{ $paginatedArticles->links() }} <!-- Laravel tự động hiển thị phân trang -->
                                </div>
                            </div>

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



        {{-- <!-- ====== start breaking news ====== -->
        <section class="tc-breaking-news-style5 pt-50 pb-50">
            <div class="container">
                <div class="content">
                    <div class="breaking-title">
                        <strong> <i class="ion-flash me-2"></i> Tin Mới</strong>
                    </div>
                    <div class="breaking-body">
                        <div class="tc-breaking-news-slider5">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($breakingNews as $article)
                                        <div class="swiper-slide">
                                            <div class="item">
                                                <a href="{{ route('articles.article', ['slug' => $article->slug]) }}"
                                                    class="hover-underline">
                                                    {{ $article->title }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- arrows -->
                        <div class="arrows">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end breaking news ====== --> --}}


        {{-- 
        <!-- ====== start trends news ====== -->
        <section class="tc-post-grid-style5 overflow-hidden">
            <div class="container">
                <div class="content pb-50 border-1 border-bottom brd-gray">
                    <div class="row gx-5">
                        <!-- Hiển thị highlightedArticle -->
                        @if ($highlightedArticle)
                            <div class="col-lg-6 border-1 border-end brd-gray mb-5 mb-lg-0">
                                <div class="item">
                                    <div class="content">
                                        <div class="tags mb-20">
                                            <a href="#">
                                                {{ $highlightedArticle->category->name }}
                                            </a>
                                        </div>
                                        <h2 class="title mb-20">
                                            <a
                                                href="{{ route('articles.article', ['slug' => $highlightedArticle->slug]) }}">
                                                {{ $highlightedArticle->title }}
                                            </a>
                                        </h2>
                                        <div class="text color-666 mb-20">
                                            {{ Str::limit($highlightedArticle->preview_content ?? strip_tags($highlightedArticle->content), 180) }}
                                        </div>
                                        <div class="meta-bot fsz-13px color-666 mb-40">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <i class="la la-calendar me-2"></i>
                                                    {{ \Carbon\Carbon::parse($highlightedArticle->created_at)->translatedFormat('d \t\há\n\g m, Y') }}
                                                </li>

                                                <li class="author me-5">
                                                    <i class="la la-user me-2"></i> by <span class="color-000">
                                                        {{ $highlightedArticle->author->name ?? 'Admin' }}
                                                    </span>
                                                </li>
                                                <li class="comment">
                                                    <i class="la la-comment me-2"></i>
                                                    {{ $highlightedArticle->comments_count }} Bình luận
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('articles.article', ['slug' => $highlightedArticle->slug]) }}"
                                        class="img img-cover d-block th-380">
                                        <img src="{{ asset('storage/' . $highlightedArticle->thumbnail_url) }}"
                                            alt="{{ $highlightedArticle->title }}">
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Hiển thị thông báo nếu không có bài viết cho highlightedArticle -->
                            <div class="col-lg-6">
                                <p>Chưa có bài viết nào.</p>
                            </div>
                        @endif

                        <!-- Hiển thị secondaryArticle -->
                        @if ($secondaryArticle)
                            <div class="col-lg-6">
                                <div class="item">
                                    <div class="content">
                                        <div class="tags mb-20">
                                            <a href="">
                                                {{ $secondaryArticle->category->name }}
                                            </a>
                                        </div>
                                        <h2 class="title mb-20">
                                            <a href="{{ route('articles.article', ['slug' => $secondaryArticle->slug]) }}">
                                                {{ $secondaryArticle->title }}
                                            </a>
                                        </h2>
                                        <div class="text color-666 mb-20">
                                            {{ Str::limit($secondaryArticle->preview_content ?? strip_tags($secondaryArticle->content), 180) }}
                                        </div>
                                        <div class="meta-bot fsz-13px color-666 mb-40">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <i class="la la-calendar me-2"></i>
                                                    {{ \Carbon\Carbon::parse($secondaryArticle->created_at)->translatedFormat('d \t\há\n\g m, Y') }}

                                                </li>
                                                <li class="author me-5">
                                                    <i class="la la-user me-2"></i> by <span class="color-000">
                                                        {{ $secondaryArticle->author->name ?? 'Admin' }}
                                                    </span>
                                                </li>
                                                <li class="comment">
                                                    <i class="la la-comment me-2"></i>
                                                    {{ $secondaryArticle->comments_count }} Bình luận
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('articles.article', ['slug' => $secondaryArticle->slug]) }}"
                                        class="img img-cover d-block th-380">
                                        <img src="{{ asset('storage/' . $secondaryArticle->thumbnail_url) }}"
                                            alt="{{ $secondaryArticle->title }}">
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Hiển thị thông báo nếu không có bài viết cho secondaryArticle -->
                            <div class="col-lg-6">
                                <p>Chưa có bài viết nào.</p>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="content pb-50 pt-50 brd-gray border-bottom">
                    <div class="row gx-5">
                        @foreach ($nebulaNuggets as $nugget)
                            <div class="col-lg-4 border-1 {{ !$loop->last ? 'border-end' : '' }} brd-gray mb-5 mb-lg-0">
                                <div class="item">
                                    <div class="content">
                                        <div class="tags mb-20">

                                            @if ($nugget->category)
                                                <a href="">
                                                    {{ $nugget->category->name }}
                                                </a>
                                            @endif
                                        </div>
                                        <h3 class="title mb-20">
                                            <a href="{{ route('articles.article', $nugget->slug) }}">
                                                {{ $nugget->title }}
                                            </a>
                                        </h3>
                                        <div class="meta-bot fsz-13px color-666 mb-30">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <a href="#">
                                                        <i class="la la-calendar me-2"></i>
                                                        {{ \Carbon\Carbon::parse($nugget->created_at)->translatedFormat('d \t\há\n\g m, Y') }}


                                                    </a>
                                                </li>
                                                <li class="comment">
                                                    <a href="#">
                                                        <i class="la la-comment me-2"></i>
                                                        {{ $nugget->comments_count }} Bình luận
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('articles.article', $nugget->slug) }}"
                                        class="img img-cover d-block th-250">
                                        <img src="{{ asset('storage/' . $nugget->thumbnail_url) }}"
                                            alt="{{ $nugget->title }}">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



                <div class="content pb-50 pt-50">
                    <section class="pb-5">
                        <div class="container">
                            <div class="row">
                                <!-- Main content -->
                                <div class="col-lg-8">
                                    <div class="features-content mb-5">
                                        <div class="tc-latest-news-style5">
                                            <a href="page-blog.html" class="color-000 text-uppercase mb-30">Bài Viết Nổi
                                                Bật<i class="la la-angle-right ms-1"></i></a>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <div class="tc-post-overlay-style5 mb-5 mb-lg-0">
                                                        <div class="tc-post-overlay-slider5">
                                                            <div class="swiper-container">
                                                                <div class="swiper-wrapper">
                                                                    @foreach ($topMainArticle as $topMainArticles)
                                                                        <div class="swiper-slide">
                                                                            <div class="item">
                                                                                <div class="img th-525 img-cover">
                                                                                    <img src="{{ asset('storage/' . $topMainArticles->thumbnail_url) }}"
                                                                                        alt="{{ $topMainArticles->title }}">
                                                                                    <div class="tags">
                                                                                        <a
                                                                                            href="{{ route('articles.article', $topMainArticles->slug) }}">
                                                                                            {{ $topMainArticles->title }}
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="info">
                                                                                    <h2 class="title mb-20">
                                                                                        <a
                                                                                            href="{{ route('articles.article', $topMainArticles->slug) }}">
                                                                                            {{ $topMainArticles->title }}
                                                                                        </a>
                                                                                    </h2>
                                                                                    <div class="text mb-40 fsz-16px">
                                                                                        {{ Str::limit(strip_tags($topMainArticles->description), 100) }}
                                                                                    </div>
                                                                                    <div
                                                                                        class="meta-bot fsz-13px text-white">
                                                                                        <ul class="d-flex">
                                                                                            <li class="date me-4">
                                                                                                <i
                                                                                                    class="la la-calendar me-2"></i>
                                                                                                {{ \Carbon\Carbon::parse($topMainArticles->created_at)->translatedFormat('d \t\há\n\g m, Y') }}


                                                                                            </li>
                                                                                            <li class="author me-4">
                                                                                                <i
                                                                                                    class="la la-user me-2"></i>
                                                                                                {{ $topMainArticles->author->name ?? 'Admin' }}
                                                                                            </li>
                                                                                            <li class="comment">
                                                                                                <i
                                                                                                    class="la la-views me-2"></i>
                                                                                                {{ $topMainArticles->views ?? 0 }}
                                                                                                lượt xem
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
                                                            <div class="arrows">
                                                                <div class="swiper-button-next"></div>
                                                                <div class="swiper-button-prev"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="tc-post-list-style5">
                                                        <div class="items">
                                                            @foreach ($topSideArticles as $article)
                                                                <div class="item {{ $loop->first ? 'pt-0' : '' }}">
                                                                    <div class="row gx-0">
                                                                        <div class="col-8 pe-10">
                                                                            <div class="content">
                                                                                <div class="tags mb-15">
                                                                                    <a
                                                                                        href="{{ route('categories.show', $article->category->slug ?? '#') }}">
                                                                                        {{ $article->category->name ?? 'Danh mục' }}
                                                                                    </a>
                                                                                </div>
                                                                                <h5 class="title">
                                                                                    <a href="{{ route('articles.article', $article->slug) }}"
                                                                                        class="hover-underline">
                                                                                        {{ $article->title }}
                                                                                    </a>
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="img th-80 img-cover">
                                                                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                                                    alt="{{ $article->title }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <br>
                                        <hr><br>

                                        <!-- Related articles -->
                                        <div class="related-articles">
                                            <div class="row">
                                                @if (isset($relatedArticles) && $relatedArticles->count() > 0)
                                                    @foreach ($relatedArticles as $article)
                                                        <div class="col-md-6 mb-4">
                                                            <div class="card h-100 border-0 shadow-sm">
                                                                <div class="item">

                                                                    <div class="tags mb-20">
                                                                        <a href="">
                                                                            @if ($secondaryArticle)
                                                                                {{ $secondaryArticle->category->name }}
                                                                            @endif

                                                                        </a>
                                                                    </div>

                                                                </div>

                                                                <div class="position-relative">

                                                                    <a
                                                                        href="{{ route('articles.article', ['slug' => $article->slug]) }}">
                                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                                            alt="{{ $article->title }}"
                                                                            class="card-img-top"
                                                                            style="height: 200px; object-fit: cover;">
                                                                    </a>

                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title mb-3">
                                                                        <a href="{{ route('articles.article', ['slug' => $article->slug]) }}"
                                                                            class="text-decoration-none text-dark hover-primary">
                                                                            {{ $article->title }}
                                                                        </a>
                                                                    </h5>
                                                                    <p class="card-text text-muted">
                                                                        {{ Str::limit(trim(strip_tags(html_entity_decode($article->content))), 200, '...') }}
                                                                    </p>

                                                                </div>
                                                                <div class="card-footer bg-white border-0">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center text-muted small">
                                                                        <span><i class="la la-calendar me-1"></i>
                                                                            {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d \t\há\n\g m, Y') }}
                                                                        </span>
                                                                        <span><i class="la la-eye me-1"></i>
                                                                            {{ $article->views ?? 0 }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-12">
                                                        <div class="alert alert-info">Không có bài viết liên quan.</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sidebar -->
                                <div class="col-lg-4">
                                    <div class="sidebar">
                                        <!-- Popular tags -->
                                        <div class="tc-post-list-style1  border-0 shadow-sm mb-4">
                                            <div
                                                class="tc-post-list-style1  bg-white border-bottom border-primary border-3">
                                                <h5 class="mb-0 fw-bold text-uppercase">Thẻ Phổ Biến</h5>
                                            </div>
                                            <div class="tc-post-list-style1 p-3">
                                                <div class="tc-post-list-style1 d-flex flex-wrap gap-2">

                                                    @foreach ($tags as $tag)
                                                        <a href="{{ route('tags.shows', ['tag' => $tag->tag_id]) }}"
                                                            class="  btn btn-sm btn-light btn-outline-secondary">{{ $tag->name }}
                                                            ({{ $tag->published_articles_count }})
                                                        </a>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Categories list -->
                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-header bg-white border-bottom border-primary border-3">
                                                <h5 class="mb-0 fw-bold text-uppercase">Danh Mục Hàng Đầu</h5>
                                            </div>
                                            <div class="list-group list-group-flush">
                                                @if (isset($categories) && $categories->count() > 0)
                                                    @foreach ($categories as $cat)
                                                        <a href="{{ route('client.category.show', $cat->slug) }}"
                                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <i class="la la-folder me-2 text-primary"></i>
                                                                <span>{{ $cat->name }}</span>
                                                            </div>
                                                            <span class="badge bg-light text-dark">
                                                                {{ $cat->total_articles_count ?? 0 }} bài viết
                                                            </span>
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <div class="list-group-item">Không có danh mục nào.</div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Recent articles -->
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-white border-bottom border-primary border-3">
                                                <h5 class="mb-0 fw-bold text-uppercase">Bài Viết Đã Xem </h5>
                                            </div>
                                            <div class="list-group list-group-flush">
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
                    </section>
                    <!-- ====== end main content ====== -->
                </div>
            </div>
        </section>
        <!-- ====== end trends news ====== --> --}}

    </main>
    <!--End-Contents-->




@endsection
