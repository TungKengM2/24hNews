<?php

namespace App\Http\Controllers; // Đảm bảo namespace đúng

use App\Models\Article;
use App\Models\Category;

class CategoryUserController extends Controller
{
    public function index($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        // Lấy bài viết thuộc danh mục
        $articles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Lấy bài viết nhiều lượt xem nhất
        $articlesViews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        // Lấy bài viết nổi bật (bài có nhiều lượt xem nhất)
        $featuredArticle = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->first();

        // Lấy 5 bài viết phụ (không trùng bài nổi bật)
        $relatedArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->where('article_id', '!=', optional($featuredArticle)->article_id) // Đổi id thành article_id
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        $categories = Category::where('is_active', 1)->get();

        return view('client.categories.categories', compact('categories', 'articles', 'articlesViews', 'category', 'featuredArticle', 'relatedArticles'));
    }
}
