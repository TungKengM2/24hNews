<?php

namespace App\Http\Controllers; // Đảm bảo namespace đúng

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;

class CategoryUserController extends Controller
{
    public function index($categoryid)
    {
        $category = Category::where('slug', $categoryid)->firstOrFail();


        $articlesNews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc') // Sắp xếp theo bài viết mới nhất
            ->limit(4)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->get();


        // Lấy bài viết thuộc danh mục
        $articles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->paginate(10);

        // Lấy bài viết nhiều lượt xem nhất
        $articlesViews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->distinct() // Loại bỏ bản ghi trùng lặp
            ->paginate(4);



        $featuredArticle = Article::with('category') // Load cả danh mục
            ->where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->limit(4)
            ->first();


        // Lấy 5 bài viết phụ (không trùng bài nổi bật)
        $recentArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->where('article_id', '!=', optional($featuredArticle)->article_id) // Đổi id thành article_id
            ->orderBy('views', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->limit(4)
            ->get();

        // Lấy các bài viết liên quan (không trùng bài trong $recentArticles)
        $relatedArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereNotIn('article_id', $recentArticles->pluck('article_id')->toArray()) // So sánh với các ID bài viết trong $recentArticles
            ->where('article_id', '!=', optional($featuredArticle)->article_id) // Đảm bảo không trùng với bài viết nổi bật
            ->orderBy('views', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->limit(4)
            ->get();


        $tags = Tag::all();

        $categories = Category::withCount('articles')
            ->where('is_active', 1)
            ->limit(7)
            ->get();

        $category2 = Category::where('is_active', 1)->get(); // Lấy danh sách danh mục



        return view('website.categories.categories', compact('relatedArticles', 'recentArticles', 'tags', 'categories', 'articlesNews', 'category2', 'articles', 'articlesViews', 'category', 'featuredArticle'));
    }
}
