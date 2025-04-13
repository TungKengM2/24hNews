@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start author header ====== -->
        <section class="tc-author-header">
            <div class="container">
                <div class="content">
                    <div class="title">
                        @if ($user->role)
                            <p class="fsz-14px color-fff op-5 mb-2">{{ ucfirst($user->role->name) }}</p>
                        @endif
                        <h2> {{ $user->username }} </h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author header ====== -->
        


        <!-- ====== start author-details ====== -->
        <section class="tc-author-details">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="">
                        <div class="content">
                            <div class="author-img img-cover">
                                <div class="widget-user-image">
                                    <img class="rounded-circle"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                                        alt="Avatar">
                                    <label for="avatarUpload" class="avatar-edit">
                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" id="avatarUpload" name="image" accept="image/*"
                                        style="display: none;">
                                </div>
                            </div>
                            <p class="color-666 mb-20"> {{ $user->description ?? 'Không Có Mô Tả Trang Cá Nhân' }}
                            <div class="info mt-20">
                                <div class="description mt-20">
                                   
                                    </p>
                                    {{-- dat them hiển thị bài viết đã xem --}}
                                        <h4 class="page-title">Lịch Sử Bài Viết Đã Xem</h4>
                                        <div class="box-body">
                                            @if ($viewedArticles->isEmpty())
                                                <p class="text-muted">Bạn chưa xem bài viết nào.</p>
                                            @else
                                                <div class="row">
                                                    @foreach ($viewedArticles as $index => $view)
                                                        <div class="col-md-4 mb-4">
                                                            <div class="card">
                                                                <div class="position-relative">
                                                                    <a href="{{ route('articles.show', $view->article->article_id) }}">
                                                                        <img src="{{ asset('storage/' . $view->article->thumbnail_url) }}"
                                                                            class="card-img-top" alt="Article thumbnail"
                                                                            style="height: 200px; object-fit: cover;">
                                                                    </a>
                                                                    <span class="position-absolute top-0 start-0 bg-dark text-white p-2">
                                                                        {{ $loop->iteration + ($viewedArticles->currentPage() - 1) * $viewedArticles->perPage() }}
                                                                    </span>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ $view->article->title }}</h5>
                                                                    <p class="card-text">{!! Str::limit(strip_tags($view->article->content), 100, '...') !!}</p>
                                                                    <a href="{{ route('article.detail', ['slug' => $view->article->slug]) }}"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="si-eye si"></i> Xem Chi Tiết
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                                                    <nav>
                                                        <ul class="pagination pagination-sm">
                                                            {{ $viewedArticles->links('pagination::bootstrap-5') }}
                                                        </ul>
                                                    </nav>
                                                </div>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
