@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start author header ====== -->
        <section class="tc-author-header">
            <div class="container">
                <div class="content">
                    <div class="title">
                        @if ($author->role)
                            <p class="fsz-14px color-fff op-5 mb-2">{{ ucfirst($author->role->name) }}</p>
                        @endif
                        <h2> {{ $author->username }} </h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author header ====== -->


        <!-- ====== start author-details ====== -->
        <section class="tc-author-details">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="content">
                            <div class="author-img img-cover">
                                <img src="{{ $author->image ? asset('storage/' . $author->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' }}"
                                    alt="{{ $author->username }}">

                            </div>
                            <div class="info">
                                <div class="rate">
                                    {{-- <p>Đánh giá trung bình:</p> --}}
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($averageRating))
                                            <i class="la la-star text-warning"></i>
                                        @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
                                            <i class="la la-star-half-alt text-warning"></i>
                                        @else
                                            <i class="la la-star-o text-secondary"></i>
                                        @endif
                                    @endfor



                                </div>
                                <div class="description mt-20">
                                    <p class="color-666 mb-20"> {{ $author->description ?? 'Không Có Mô Tả Trang Cá Nhân' }}
                                    </p>
                                    <p class="color-666 mb-20"> <i class="la la-book"></i> {{ $author->articles_count }}
                                        Posts
                                        <span class="mx-3"> |
                                        </span> <i class="la la-user"></i> {{ $followerCount }} Followers
                                    </p>
                                </div>
                                <div class="follow">
                                    @if (auth()->check() && auth()->id() !== $author->user_id)
                                        @if (auth()->user()->following()->where('following_id', $author->user_id)->exists())
                                            <form action="{{ route('user.unfollow', $author->user_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Unfollow</button>
                                            </form>
                                        @else
                                            <form action="{{ route('user.follow', $author->user_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Follow</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>

                                {{-- <div class="social-links">
                                        <a href="page-author.html#"> <i class="la la-facebook-f"></i> </a>
                                        <a href="page-author.html#"> <i class="la la-twitter"></i> </a>
                                        <a href="page-author.html#"> <i class="la la-behance"></i> </a>
                                        <a href="page-author.html#"> <i class="la la-youtube"></i> </a>
                                    </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author-details ====== -->
        <section class="tc-author-post pb-100">
            <div class="container">
                <div class="row">
                    <div class="posts">
                        <div class="posts-side">
                            <p class="color-000 text-uppercase mb-30 ltspc-1">
                                <a href="{{ route('articles.index') }}">Recently Added</a>
                                <i class="la la-angle-right ms-1"></i>
                            </p>

                            @if ($author->articles->count() > 0)
                                @foreach ($author->articles as $article)
                                    <div class="tc-post-overlay-default">
                                        <div class="img th-600 img-cover">
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}">
                                            <div class="tags">
                                                <a href="{{ route('categories.show', $article->category_id) }}">
                                                    {{ $article->category->name ?? 'Uncategorized' }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="content ps-40 pe-40 pb-40">
                                            <h2 class="title mb-30">
                                                <a href="{{ route('articles.article', $article->slug) }}">
                                                    {{ $article->title }}
                                                </a>
                                            </h2>
                                            <div class="meta-bot lh-1">
                                                <ul class="d-flex">
                                                    <li class="date me-5">
                                                        <a href="#">
                                                            <i class="la la-calendar me-2"></i>
                                                            {{ $article->created_at->format('M d, Y') }}
                                                        </a>
                                                    </li>
                                                    <li class="author me-5">
                                                        <a href="{{ route('website.profile', $article->author_id) }}">
                                                            <i class="la la-user me-2"></i>
                                                            by {{ $article->author->username }}
                                                        </a>
                                                    </li>
                                                    <li class="comment">
                                                        <a href="{{ route('articles.show', $article->slug) }}#comments">
                                                            <i class="la la-comment me-2"></i>
                                                            {{ $article->comments->count() }} Comments
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Chưa có bài viết nào.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
