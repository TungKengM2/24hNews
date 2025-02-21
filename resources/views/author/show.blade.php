@extends('author.layouts.app')
@section('title', 'Quản lý bài viết')

@section('content')

    <div class="container mt-5">
        <div class="card p-4">
            <h2 class="mb-4">{{ $article->title }}</h2>

            <!-- Hiển thị thông tin cơ bản -->
            <div class="mb-3">
                <p><strong>Slug:</strong> {{ $article->slug }}</p>
                <p><strong>Danh mục:</strong> {{ $article->category->name }}</p>
                <p><strong>Tác giả:</strong> {{ $article->author->username }}</p>
                <p><strong>Trạng thái:</strong> {{ ucfirst($article->status) }}</p>
                <p><strong>Lượt xem:</strong> {{ $article->views }}</p>
                <p><strong>Ngày tạo:</strong> {{ $article->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $article->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Hiển thị nội dung bài viết -->
            <div class="mb-3">
                <h4>Nội dung</h4>
                <div>{!! nl2br(e($article->content)) !!}</div>
            </div>

            <!-- Hiển thị ảnh đại diện -->
            @if ($article->thumbnail_url)
                <div class="mb-3">
                    <h4>Ảnh đại diện</h4>
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail"
                         style="max-width: 100%; height: auto;">
                </div>
            @endif

            <!-- Nút quay lại -->
            <a href="{{ route('author.dashboard') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>

@endsection
