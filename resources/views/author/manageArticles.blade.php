@extends('author.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section id="posts">
        <div class="add-post-button">
            <a href="#">Thêm bài viết</a>
        </div>
        <h2>Quản lý bài viết</h2>
        <div class="filter-bar">
            <div class="filters">
                <a href="#">All (10)</a>
                <a href="#">Draft (2)</a>
                <a href="#">Pending (3)</a>
                <a href="#">Published (5)</a>
                <a href="#">Archived (1)</a>
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
            <tr>
                <td><input type="checkbox"></td>
                <td>
                    <div class="post-title">
                        <img src="thumbnail.jpg" alt="Thumbnail">
                        <div>
                            <a href="#">Bài viết mẫu</a>
                            <div class="post-actions">
                                <a href="#">Edit</a>
                                <a href="#">View</a>
                                <a href="#" style="color: red;">Delete</a>
                            </div>
                        </div>
                    </div>
                </td>
                <td>Đã đăng</td>
                <td>News</td>
                <td>123</td>
                <td>2025-02-20</td>
            </tr>
            </tbody>
        </table>
    </section>
@endsection
