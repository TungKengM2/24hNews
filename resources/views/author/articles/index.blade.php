@extends('author.layouts.master')

@section('title')
    Danh Sách Bài Viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Danh Sách Bài Viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Viết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <div class="container-full">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <button type="button" class="waves-effect waves-light btn btn-default mb-5">
                                    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
                                </button>
                                <a href="{{ route('author.articles.create') }}"
                                   class="waves-effect waves-light btn btn-primary mb-5 ml-2">
                                    <i class="si-plus si"></i>
                                </a>
                            </div>

                            <div class="input-group" style="width: 300px;">
                                <input type="text" id="searchInput" class="form-control"
                                       placeholder="Tìm kiếm bài viết...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="complex_header" class="table table-striped table-bordered display"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Contains Sensitive Content</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Thumbnail</th>
                                        <th>Status</th>
                                        <th>Views</th>
                                        <th>Tags</th>
                                        {{--                                        <th>Approved By</th>--}}
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td>{{ $article->article_id }}</td>
                                            <td>{{ $article->title }}</td>
                                            <td>{{ $article->slug }}</td>
                                            <td class="text-center">
                                                @if ($article->contains_sensitive_content)
                                                    <span class="badge bg-danger">Yes</span>
                                                @else
                                                    <span class="badge bg-success">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $article->author->username ?? 'Unknown' }}</td>
                                            <td>{{ $article->category->name ?? 'Uncategorized' }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                     alt="Thumbnail" width="100" height="150">

                                            </td>
                                            <td>
                                                @switch($article->status)
                                                    @case('draft')
                                                        <span class="badge bg-secondary">Draft</span>
                                                        @break

                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @break

                                                    @case('published')
                                                        <span class="badge bg-success">Published</span>
                                                        @break

                                                    @case('archived')
                                                        <span class="badge bg-danger">Archived</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $article->views }}</td>
                                            <td>
                                                @if ($article->tags->isNotEmpty())
                                                    @foreach ($article->tags as $tag)
                                                        <span class="badge bg-primary">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Không có tag</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('author.articles.show', $article) }}"
                                                   class="btn btn-info btn-sm"><i class="si-eye si"></i></a>

                                                <a href="{{ route('author.articles.edit', $article) }}"
                                                   class="btn btn-warning btn-sm"><i class="si-pencil si"></i></a>


                                                <button class="btn btn-danger btn-sm"
                                                        onclick="deleteArticle({{ $article->article_id }})">
                                                    <i class="si-trash si"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $articles->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#searchInput').on('input', function () {
                        const query = $(this).val().trim();
                        if (!query) {
                            $('table tbody').empty();
                            return;
                        }

                        $.ajax({
                            url: "{{ route('author.articles.search') }}",
                            method: 'GET',
                            data: { query: query },
                            success: function (response) {
                                console.log('Server response:', response);

                                $('table tbody').empty();

                                if (response.data.length > 0) {
                                    response.data.forEach(article => {
                                        const html = `
                            <tr>
                                <td>${article.article_id}</td>
                                <td>${article.title}</td>
                                <td>${article.slug}</td>
                                <td>${article.category?.name || 'N/A'}</td>
                                <td>${article.tags.map(tag => tag.name).join(', ')}</td>
                            </tr>
                        `;
                                        $('table tbody').append(html);
                                    });
                                } else {
                                    $('table tbody').append('<tr><td colspan="5">Không tìm thấy kết quả</td></tr>');
                                }

                                $('#pagination').html(response.links);
                            },
                            error: function (xhr) {
                                console.error('AJAX Error:', xhr.responseText);
                            },
                        });
                    });
                });
            </script>
            <script>
                function deleteArticle(articleId) {
                    console.log('deleteArticle called with articleId:', articleId);
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger',
                        },
                        buttonsStyling: false,
                    });

                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/author/articles/${articleId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                },
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to delete article');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    swalWithBootstrapButtons.fire({
                                        title: 'Deleted!',
                                        text: data.message,
                                        icon: 'success',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    swalWithBootstrapButtons.fire({
                                        title: 'Error!',
                                        text: 'An error occurred while deleting the article.',
                                        icon: 'error',
                                    });
                                });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            swalWithBootstrapButtons.fire({
                                title: 'Cancelled',
                                text: 'Your article is safe :)',
                                icon: 'error',
                            });
                        }
                    });
                }
            </script>
@endsection
