<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        // breaking news
        $featuredArticles = Article::where('status', 'published')
            ->orderByDesc('created_at') // Sắp xếp theo thời gian mới nhất
            ->take(7)
            ->get();

            

        // top 2 bài viết nhiều lượt xem
        $D1Articles = Article::where('status', 'published')
            ->orderByDesc('views') // Sắp xếp bài viết nhiều views nhất
            ->take(2) // Lấy top 2 bài viết nhiều lượt xem
            ->get();

        // Lấy danh sách bài viết mới nhất
        $articles = Article::where('status', 'published')->latest()->get();

        $trendingPosts = Article::withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(5)
            ->get();

        $journalists = User::where('role_id', 3)
            ->get(); // Lấy nhà báo có ID = 3

        $sportsArticles = Article::whereHas('category', function ($query) {
            $query->where('name', 'Thể Thao'); // Hoặc sử dụng category_id cụ thể
        })->inRandomOrder()->distinct()->get();

        $categories = Category::where('is_active', 1)->get();
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

        // Truyền dữ liệu bài viết tới view
        return view('welcome', compact('categories', 'sportsArticles', 'newsData', 'journalists', 'trendingPosts', 'featuredArticles', 'articles', 'D1Articles'));
    }

    // dat thêm hàm search
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $results = Article::where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('category_id', 'LIKE', "%{$keyword}%")
            ->get();

        // Fetch the featured articles again for the search results view
        $featuredArticles = Article::where('status', 'published')
            ->orderByDesc('created_at')
            ->take(7)
            ->get();
            $D1Articles = Article::where('status', 'published')
            ->orderByDesc('views') // Sắp xếp bài viết nhiều views nhất
            ->take(2) // Lấy top 2 bài viết nhiều lượt xem
            ->get();

        // Lấy danh sách bài viết mới nhất
        $articles = Article::where('status', 'published')->latest()->get();

        $trendingPosts = Article::withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(5)
            ->get();

        $journalists = User::where('role_id', 3)
            ->get(); // Lấy nhà báo có ID = 3

        $sportsArticles = Article::whereHas('category', function ($query) {
            $query->where('name', 'Thể Thao'); // Hoặc sử dụng category_id cụ thể
        })->inRandomOrder()->distinct()->get();

        $categories = Category::where('is_active', 1)->get();
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

        return view('welcome', compact('results', 'keyword', 'categories', 'sportsArticles', 'newsData', 'journalists', 'trendingPosts', 'featuredArticles', 'articles', 'D1Articles'));
    }
    function profileadmin() {
        return view('admin.profile');
    }
}