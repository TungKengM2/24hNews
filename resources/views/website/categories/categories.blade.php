@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start category header ====== -->
        <section class="tc-category-header py-4 bg-light border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="mb-2">{{ $category->name }}</h1>
                        <p class="text-muted mb-0">{{ $category->description ?? 'Khám phá các bài viết trong danh mục này' }}</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end category header ====== -->

        <!-- ====== start articles by views ====== -->
        <section class="tc-articles-by-views py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="fw-bold text-uppercase mb-4 border-start border-primary border-4 ps-3">Bài Viết Nổi Bật</h4>
                        <div class="tc-post-grid-default">
                            <div class="tc-slider-style1">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @if(isset($articlesViews) && $articlesViews->count() > 0)
                                            @foreach($articlesViews as $articleviews)
                                                <div class="swiper-slide">
                                                    <div class="item d-block">
                                                        <div class="row gx-4 align-items-center">
                                                            <div class="col-6">
                                                                <a href="{{ Auth::check() ? route('articles.article', ['slug' => $articleviews->slug]) : url('/login-user') }}" 
                                                                   class="img th-200 img-cover rounded overflow-hidden">
                                                                    <img src="{{ asset('storage/' . $articleviews->thumbnail_url) }}"
                                                                        alt="{{ $articleviews->title }}" class="w-100 h-100 object-fit-cover">
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="content">
                                                                    <h5 class="title mb-3">
                                                                        <a href="{{ Auth::check() ? route('articles.article', ['slug' => $articleviews->slug]) : url('/login-user') }}"
                                                                           class="text-dark hover-primary text-decoration-none">
                                                                            {{ $articleviews->title }}
                                                                        </a>
                                                                    </h5>
                                                                    <div class="meta-bot mt-3 text-muted d-flex align-items-center">
                                                                        <i class="la la-clock me-1"></i>
                                                                        <span>{{ $articleviews->created_at->diffForHumans() }}</span>
                                                                        <span class="mx-2">|</span>
                                                                        <i class="la la-eye me-1"></i>
                                                                        <span>{{ $articleviews->views ?? 0 }} lượt xem</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="swiper-slide">
                                                <div class="alert alert-info m-0">Không có bài viết nào được hiển thị.</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end articles by views ====== -->

        <!-- ====== start main content ====== -->
        <section class="pb-5">
            <div class="container">
                <div class="row">
                    <!-- Main content -->
                    <div class="col-lg-8">
                        <div class="features-content mb-5">
                            <h4 class="fw-bold text-uppercase mb-4 border-start border-primary border-4 ps-3">Bài Viết Mới Nhất</h4>
                            
                            @if (isset($featuredArticle) && $featuredArticle)
                                <div class="featured-article mb-5">
                                    <div class="card border-0 shadow-sm overflow-hidden">
                                        <div class="position-relative">
                                            <a href="{{ route('articles.article', ['slug' => $featuredArticle->slug]) }}">
                                                <img src="{{ asset('storage/' . $featuredArticle->thumbnail_url) }}" 
                                                     alt="{{ $featuredArticle->title }}" 
                                                     class="card-img-top" style="height: 400px; object-fit: cover;">
                                            </a>
                                            <div class="position-absolute top-0 start-0 m-3">
                                                <span class="badge bg-primary">{{ $featuredArticle->category->name }}</span>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <h3 class="card-title mb-3">
                                                <a href="{{ route('articles.article', ['slug' => $featuredArticle->slug]) }}" 
                                                   class="text-decoration-none text-dark hover-primary">
                                                    {{ $featuredArticle->title }}
                                                </a>
                                            </h3>
                                            <p class="card-text text-muted mb-3">
                                                {{ Str::limit(strip_tags($featuredArticle->content), 200) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $featuredArticle->author->image ? asset('storage/' . $featuredArticle->author->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' }}" 
                                                         alt="{{ $featuredArticle->author->username }}" 
                                                         class="rounded-circle me-2" width="40" height="40">
                                                    <div>
                                                        <h6 class="mb-0">{{ $featuredArticle->author->username }}</h6>
                                                        <small class="text-muted">{{ $featuredArticle->created_at->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="la la-eye me-1"></i>
                                                    <span class="me-3">{{ $featuredArticle->views ?? 0 }}</span>
                                                    <i class="la la-comment me-1"></i>
                                                    <span>{{ $featuredArticle->comments->count() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Related articles -->
                            <div class="related-articles">
                                <div class="row">
                                    @if (isset($relatedArticles) && $relatedArticles->count() > 0)
                                        @foreach ($relatedArticles as $article)
                                            <div class="col-md-6 mb-4">
                                                <div class="card h-100 border-0 shadow-sm">
                                                    <div class="position-relative">
                                                        <a href="{{ route('articles.article', ['slug' => $article->slug]) }}">
                                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" 
                                                                 alt="{{ $article->title }}" 
                                                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                                                        </a>
                                                        <div class="position-absolute top-0 start-0 m-2">
                                                            <span class="badge bg-primary">{{ $article->category->name }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-3">
                                                            <a href="{{ route('articles.article', ['slug' => $article->slug]) }}" 
                                                               class="text-decoration-none text-dark hover-primary">
                                                                {{ $article->title }}
                                                            </a>
                                                        </h5>
                                                        <p class="card-text text-muted">
                                                            {{ Str::limit(strip_tags($article->content), 100) }}
                                                        </p>
                                                    </div>
                                                    <div class="card-footer bg-white border-0">
                                                        <div class="d-flex justify-content-between align-items-center text-muted small">
                                                            <span><i class="la la-calendar me-1"></i> {{ $article->created_at->format('d/m/Y') }}</span>
                                                            <span><i class="la la-eye me-1"></i> {{ $article->views ?? 0 }}</span>
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
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom border-primary border-3">
                                    <h5 class="mb-0 fw-bold text-uppercase">Thẻ Phổ Biến</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Covid-19</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Bitcoin</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">WordPress</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Elon Musk</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Google Cloud</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Figma</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Tiền điện tử</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Chợ trực tuyến</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Graphicriver</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Categories list -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom border-primary border-3">
                                    <h5 class="mb-0 fw-bold text-uppercase">Danh Mục Hàng Đầu</h5>
                                </div>
                                <div class="list-group list-group-flush">
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $cat)
                                            <a href="{{ route('client.category.show', $cat->slug) }}" 
                                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="la la-folder me-2 text-primary"></i>
                                                    <span>{{ $cat->name }}</span>
                                                </div>
                                                <span class="badge bg-light text-dark">
                                                    {{ $cat->articles_count ?? 0 }} bài viết
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
                                    <h5 class="mb-0 fw-bold text-uppercase">Bài Viết Gần Đây</h5>
                                </div>
                                <div class="list-group list-group-flush">
                                    @if(isset($recentArticles) && $recentArticles->count() > 0)
                                        @foreach($recentArticles as $recentArticle)
                                            <a href="{{ route('articles.article', $recentArticle->slug) }}" 
                                               class="list-group-item list-group-item-action d-flex align-items-center p-3">
                                                <img src="{{ asset('storage/' . $recentArticle->thumbnail_url) }}" 
                                                     alt="{{ $recentArticle->title }}" 
                                                     class="me-3 rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">{{ Str::limit($recentArticle->title, 50) }}</h6>
                                                    <small class="text-muted">
                                                        <i class="la la-calendar me-1"></i> {{ $recentArticle->created_at->format('d/m/Y') }}
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
    </main>
@endsection
