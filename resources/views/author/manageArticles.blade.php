@extends('author.layouts.app')
@section('title', 'Quản lý bài viết')
@section('content')
    <section id="posts">
        <div class="add-post-button">
            <a href="{{ route('author.articles.create') }}">Thêm bài viết</a>
        </div>
        <h2>Quản lý bài viết</h2>
        <div class="filter-bar">
            <div class="filters">
                <a href="#">All ({{ $articles->total() }})</a>
                <a href="#">Draft ({{ $articles->where('status', 'draft')->count() }})</a>
                <a href="#">Pending ({{ $articles->where('status', 'pending')->count() }})</a>
                <a href="#">Published ({{ $articles->where('status', 'published')->count() }})</a>
                <a href="#">Archived ({{ $articles->where('status', 'archived')->count() }})</a>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm bài viết...">
                <button>Tìm kiếm</button>
            </div>
        </div>
        <div class="bulk-actions">
            <select>
                <option value="">Bulk Actions</option>
                <option value="delete">Delete</option>
            </select>
            <button>Apply</button>
            <select>
                <option value="">All Dates</option>
            </select>
            <select>
                <option value="">All Categories</option>
            </select>
            <button>Filter</button>
        </div>
        <table>
            <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Tiêu đề</th>
                <th>Trạng thái</th>
                <th>Tags</th>
                <th>Lượt xem</th>
                <th>Ngày tạo/sửa</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($articles as $article)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <div class="post-title">
                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail">
                            <div>
                                <a href="{{ route('client.articles.article', ['article_id' => $article->article_id]) }}">{{ $article->title }}</a>
                                <div class="post-actions">
                                    <a href="{{ route('author.articles.edit', ['article' => $article->article_id]) }}">Edit</a>
                                    <a href="{{ route('client.articles.article', ['article_id' => $article->article_id]) }}">View</a>
                                    <a href="#" style="color: red;">Delete</a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ ucfirst($article->status) }}</td>
                    <td>
                        @if ($article->tags->isNotEmpty())
                            @foreach ($article->tags as $tag)
                                <span>{{ $tag->name }}</span>
                            @endforeach
                        @else
                            <span>No tags</span>
                        @endif
                    </td>
                    <td>{{ $article->views }}</td>
                    <td>{{ $article->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Không có bài viết nào.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination">
            {{ $articles->links() }}
        </div>
    </section>
@endsection
