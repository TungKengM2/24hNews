@extends('website.layouts.master')

@section('content')
<style>
    .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 60px;
}

</style>

    <main>
         <!-- ====== start nav search ====== -->
         <div class="tc-blog-nav-search py-4 border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="info">
                            <h1 class="fw-bold mb-2">Bài viết mới</h1>
                            <p class="fw-semibold mb-3">
                              Khám phá các bài viết trong trang này
                            </p>


                        </div>
                    </div>

                    <div class="col-lg-5">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="#">Bài viết mới</a></li>


                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
        <!-- ====== end nav search ====== -->



        <section class="tc-posts-tabs-style4 pt-60 pb-60">
            <div class="container">
                <div class="tc-tabs-body tc-post-grid-style4 mt-50">
                    <div class="row gx-0" id="articles-list">
                        @foreach ($articles as $article)
                            <div class="col-lg-3 border-1 border-end brd-gray mb-4">
                                <div class="item">
                                    <a href="{{ url('article', $article->slug) }}" class="img img-cover">
                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}">
                                    </a>
                                    <div class="info p-3">
                                        <h4 class="title fs-6 mb-2">
                                            <a href="{{ route('articles.article', $article->slug) }}">{{ $article->title }}</a>
                                        </h4>

                                        <div class="category text-muted small mb-2">
                                            {{ optional($article->category)->name ?? 'Chưa có danh mục' }}
                                        </div>

                                        <div class="text small mb-2">
                                            {{ Str::limit(html_entity_decode(strip_tags($article->content)), 100) }}
                                        </div>

                                        <a href="{{ route('articles.article', $article->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Phân trang -->
                <div class="pagination mt-30 text-center">
                    {!! $articles->links() !!}
                </div>

            </div>
        </section>

        <!-- ====== start another-news ====== -->
        @if ($topCategoriesWithArticles->isNotEmpty())
            <!-- Kiểm tra nếu có dữ liệu trong topCategoriesWithArticles -->
            <section class="another-news pt-50 pb-50 border-1 border-top brd-gray">
                <div class="container">
                    <h3 class="mb-10"></h3>
                    <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html"> </a>

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
                                        href="{{ route('client.category.show', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
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
                                                            <a href="{{ route('client.category.show', ['slug' => $category->slug]) }}"
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
