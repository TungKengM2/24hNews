@extends('moderator.layouts.master')

@section('title')
    Hoạt Động Bình Luận
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="col-12">
                <div class="box">
                    <h4 class="page-title">Bình luận của {{ $user->username }}</h4>
                    <div class="box-body">
                        <div class="table-responsive">
                            @if ($comments->isEmpty())
                                <p>Người dùng này chưa có bình luận nào.</p>
                            @else
                                <table class="table table-bordered table-dark mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Bài viết</th>
                                            <th>Nội dung</th>
                                            <th>Thời Gian</th>
                                            <th>Chi Tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $index => $comment)
                                            <tr>
                                                <td>{{ $loop->iteration + ($comments->currentPage() - 1) * $comments->perPage() }}
                                                </td>
                                                <td>
                                                    @if ($comment->article)
                                                        {{ $comment->article->title }}
                                                    @else
                                                        <span class="text-danger">Bài viết không tồn tại</span>
                                                    @endif
                                                </td>

                                                <td>{{ $comment->content }}</td>
                                                <td>{{ $comment->created_at->diffForHumans() }}</td>
                                                <td>
                                                    @if ($comment->article)
                                                        <a href="{{ route('moderator.article.detail', ['slug' => $comment->article->slug]) }}#comment-{{ $comment->comment_id }}"
                                                            class="btn btn-sm btn-primary">
                                                            Xem Chi Tiết
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Không có bài viết</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <!-- Phân trang -->
                        <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                            <nav>
                                <ul class="pagination pagination-sm">
                                    {{ $comments->links('pagination::bootstrap-5') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
