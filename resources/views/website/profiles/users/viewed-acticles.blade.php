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
                                    <div class="content-wrapper">
                                        <div class="container-full">
                                            <div class="col-12">
                                                <div class="box">
                                                    <h4 class="page-title">Lịch Sử Bài Viết Đã Xem</h4>
                                                    <div class="box-body">
                                                        <div class="table-responsive">
                                                            @if ($viewedArticles->isEmpty())
                                                                <p class="text-muted">Bạn chưa xem bài viết nào.</p>
                                                            @endif
                                                            <table class="table table-bordered table-light mb-0" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>STT</th>
                                                                        <th>Ảnh Đại Diện</th>
                                                                        <th>Tiêu Đề</th>
                                                                        <th>Nội Dung</th>
                                                                        <th>Hoạt Động</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($viewedArticles as $index => $view)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration + ($viewedArticles->currentPage() - 1) * $viewedArticles->perPage() }}
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ route('articles.show', $view->article->article_id) }}">
                                                                                    <img src="{{ asset('storage/' . $view->article->thumbnail_url) }}"
                                                                                        width="100px" height="100px">
                                                                                </a>
                                                                            </td>
                                                                            <td>{{ $view->article->title }}</td>
                                                                            <td>{!! Str::limit(strip_tags($view->article->content), 100, '...') !!}</td>
                                                                            <td>
                                                                                <a href="{{ route('article.detail', ['slug' => $view->article->slug]) }}"
                                                                                    class="btn btn-primary btn-sm">
                                                                                    <i class="fas fa-eye"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                                                                <nav>
                                                                    <ul class="pagination pagination-sm">
                                                                        {{ $viewedArticles->links('pagination::bootstrap-5') }}
                                                                    </ul>
                                                                </nav>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
