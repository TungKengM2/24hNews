<?php

namespace App\Http\Controllers; // Đảm bảo namespace đúng

use App\Models\Article;
use App\Models\Category;

class CategoryUserController extends Controller
{
    public function index($categoryid)
    {
        $category = Category::where('slug', $categoryid)->firstOrFail();

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
            ->distinct() // Loại bỏ bản ghi trùng lặp
            ->paginate(4);


        // Lấy bài viết nổi bật (bài có nhiều lượt xem nhất)
        $featuredArticle = Article::with('category') // Load cả danh mục
            ->where('category_id', $category->category_id)
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


        $categories = Category::where('is_active', 1)->limit(7)->get();
        $newsData = [];
        foreach ($categories as $category) {
            $article = Article::where('category_id', $category->category_id)
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($article) {
                $newsData[] = [
                    'category' => $category,
                    'article' => $article,
                ];
            }
        }
        $category2 = Category::where('is_active', 1)->get(); // Lấy danh sách danh mục
        $categoryCount = $category2->count(); // Đếm số danh mục

        $newsData = [];
        foreach ($category2 as $category) {
            $article = Article::where('category_id', $category->category_id)
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($article) {
                $newsData[] = [
                    'category' => $category,
                    'article' => $article,
                ];
            }
        }


        return view('website.categories.categories', compact('categories', 'category2', 'articles', 'articlesViews', 'category', 'featuredArticle', 'relatedArticles'));
    }
}
