@extends('user.layouts.master')

@section('title')
    Lịch Sử Bài Viết Đã Xem
@endsection

@section('content')
   <div class="content-wrapper">
       <div class="container-full">
          <div class="row">
            <div class="col-12">
                <div class="box">
                    <h4 class="page-title">Lịch Sử Bài Viết Đã Xem</h4>
                    <div class="box-body">
                        @foreach ($viewedArticles as $index => $view)
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{ asset('storage/' . $view->article->thumbnail_url) }}" width="100px" height="100px">
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $view->article->title }}</h5>
                                    <p>{!! Str::limit(strip_tags($view->article->content), 100, '...') !!}</p>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('article.detail', ['slug' => $view->article->slug]) }}" class="btn btn-primary btn-sm">
                                        <i class="si-eye si"></i>
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    {{ $loop->iteration + ($viewedArticles->currentPage() - 1) * $viewedArticles->perPage() }}
                                </div>
                            </div>
                            <hr>
                        @endforeach
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
