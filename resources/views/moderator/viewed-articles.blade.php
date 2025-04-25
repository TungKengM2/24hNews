@extends('moderator.layouts.master')

@section('title')
    Lịch Sử Bài Viết Đã Xem
@endsection

@section('content')
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
                            <table class="table table-bordered mb-0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh Đại Diện</th>
                                        <th>Tiêu Đề</th>
                                        <th>Nội Dung</th>
                                        <th>Action</th>
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
                                                <a href="{{ route('moderator.article.detail', ['slug' => $view->article->slug]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="si-eye si"></i>
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
@endsection
