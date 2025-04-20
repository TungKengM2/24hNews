@extends('author.layouts.master')

@section('title')
    Bài Viết Đã Lưu
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <div class="container-full">
                <div class="col-12">
                    <div class="box">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}

                            </div>
                        @endif

                        {{-- @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}

                            </div>
                        @endif --}}
                        <h4 class="page-title">Danh Sách Bài Viết Đã Lưu</h4>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ảnh Đại Diện</th>
                                            <th>Tiêu Đề</th>
                                            <th>Nội Dung</th>
                                            <th>Thời Gian</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    @foreach ($savedArticles as $index => $savedArticle)
                                        <tbody>
                                            <td>
                                                {{ $loop->iteration + ($savedArticles->currentPage() - 1) * $savedArticles->perPage() }}
                                            </td>
                                            <td>
                                                <a href="{{ route('articles.show', $savedArticle->article->article_id) }}">
                                                    <img src="{{ asset('storage/' . $savedArticle->article->thumbnail_url) }}"
                                                        width="100px" height="100px">
                                                </a>
                                            </td>
                                            <td>
                                                <h5 class="card-title">{{ $savedArticle->article->title }}</h5>
                                            </td>
                                            <td>
                                                {!! Str::limit(strip_tags($savedArticle->article->content), 100, '...') !!}
                                            </td>
                                            <td>
                                                <h5 class="card-title">{{ $savedArticle->created_at->diffForHumans() }}
                                                </h5>
                                            </td>
                                            <td>
                                                <a href="{{ route('author.article.detail', ['slug' => $savedArticle->article->slug]) }}"
                                                    class="btn btn-primary btn-sm"><i class="si-eye si"></i>
                                                </a>
                                                <form action="{{ route('author.remove.saved', $savedArticle->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                                        <i class="si-trash si"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tbody>
                                    @endforeach
                                </table>
                                <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                                    <nav>
                                        <ul class="pagination pagination-sm">
                                            {{ $savedArticles->links('pagination::bootstrap-5') }}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelectorAll(".remove-bookmark").forEach(button => {
                            button.addEventListener("click", function() {
                                let saveId = this.getAttribute("data-id");

                                fetch(`/user/remove-saved-article/${saveId}`, {
                                        method: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute("content"),
                                            "Content-Type": "application/json"
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        alert(data.message);
                                        location.reload();
                                    })
                                    .catch(error => console.error("Lỗi:", error));
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
