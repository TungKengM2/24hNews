@extends('admin.layouts.master')

@section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h4 class="page-title">Cập Nhập Bài Viết</h4>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                    class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                        <li class="breadcrumb-item active" aria-current="page">Cập Nhập</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Main content -->
                <div class="card p-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                        id="articleForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $article->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ $article->slug }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung</label>
                            <textarea id="content" name="content" class="form-control">{!! $article->content !!}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chọn hoặc thêm tags:</label>
                            <select name="tags[]" class="form-control select2" multiple="multiple">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->tag_id }}"
                                        @if (in_array($tag->tag_id, $selectedTags)) selected @endif>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                        <div class="mt-3">
                            <label class="form-label" for="thumbnail_url">Ảnh Đại Diện</label>
                            <input class="form-control" type="file" name="thumbnail_url" id="thumbnail_url">
                            @if ($article->thumbnail_url)
                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail"
                                    width="100">
                            @endif
                        </div>


                        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                    </form>
                </div>

                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            tags: true,
                            tokenSeparators: [','],
                            placeholder: "Chọn hoặc nhập tags mới",
                            allowClear: true
                        });
                    });

                    document.getElementById("title").addEventListener("input", function() {
                        let title = this.value.trim();
                        let slug = title.toLowerCase()
                            .normalize("NFD").replace(/[̀-ͯ]/g, "")
                            .replace(/đ/g, "d").replace(/Đ/g, "D")
                            .replace(/\s+/g, "-")
                            .replace(/[^\w-]/g, "")
                            .replace(/--+/g, "-")
                            .replace(/^-+|-+$/g, "");

                        document.getElementById("slug").value = slug;
                    });
                </script>
            </div>
        </div>


                <!-- /.content-wrapper -->    
@endsection