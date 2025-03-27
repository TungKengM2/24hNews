<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $results = Article::where('status', 'published')
            ->where(function($query) use ($keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('category_id', 'LIKE', "%{$keyword}%");
            })
            ->get();

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

        $category2 = Category::where('is_active', 1)->get();

        //TungKeng làm hiển thị bài viết của author mà user đã fl
        $user = auth()->user();

        if (!$user) {
            return view('welcome', [
                'categories' => $categories ?? null,
                'category2' => $category2 ?? null,
                'sportsArticles' => $sportsArticles ?? null,
                'newsData' => $newsData ?? null,
                'journalists' => $journalists ?? null,
                'trendingPosts' => $trendingPosts ?? null,
                'featuredArticles' => $featuredArticles ?? null,
                'articles' => $articles ?? null,
                'D1Articles' => $D1Articles ?? null,
                'articlesfollow' => collect(),
                'followMessage' => 'Bạn chưa đăng ký/đăng nhập để theo dõi tác giả.'
            ]);
        }

        $followMessage = $user ? '' : 'Bạn chưa đăng ký/đăng nhập để theo dõi tác giả.';


        // Lấy danh sách ID của những tác giả mà user đang follow
        $followingIds = $user->following()->pluck('following_id');

        // Lấy bài viết của những tác giả đó
        $articlesfollow = Article::whereIn('author_id', $followingIds)
            ->where('status', 'published') // Chỉ lấy bài đã đăng
            ->latest() // Sắp xếp theo mới nhất
            ->get();


        // Truyền dữ liệu bài viết tới view
        return view('welcome', compact('categories', 'category2', 'sportsArticles', 'newsData', 'journalists', 'trendingPosts', 'featuredArticles', 'articles', 'D1Articles', 'articlesfollow', 'followMessage'));
    }

    // dat thêm hàm search
    // public function search(Request $request)
    // {
    //     $keyword = $request->input('keyword');
    //     $results = Article::where('title', 'LIKE', "%{$keyword}%")
    //         ->orWhere('category_id', 'LIKE', "%{$keyword}%")
    //         ->get();

    //     // Fetch the featured articles again for the search results view
    //     $featuredArticles = Article::where('status', 'published')
    //         ->orderByDesc('created_at')
    //         ->take(7)
    //         ->get();
    //     $D1Articles = Article::where('status', 'published')
    //         ->orderByDesc('views') // Sắp xếp bài viết nhiều views nhất
    //         ->take(2) // Lấy top 2 bài viết nhiều lượt xem
    //         ->get();

    //     // Lấy danh sách bài viết mới nhất
    //     $articles = Article::where('status', 'published')->latest()->get();

    //     $trendingPosts = Article::withCount('comments')
    //         ->orderByDesc('comments_count')
    //         ->limit(5)
    //         ->get();

    //     $journalists = User::where('role_id', 3)
    //         ->get(); // Lấy nhà báo có ID = 3

    //     $sportsArticles = Article::whereHas('category', function ($query) {
    //         $query->where('name', 'Thể Thao'); // Hoặc sử dụng category_id cụ thể
    //     })->inRandomOrder()->distinct()->get();

    //     $categories = Category::where('is_active', 1)->limit(7)->get();
    //     $newsData = [];
    //     foreach ($categories as $category) {
    //         $article = Article::where('category_id', $category->category_id)
    //             ->where('status', 'published')
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         if ($article) {
    //             $newsData[] = [
    //                 'category' => $category,
    //                 'article' => $article,
    //             ];
    //         }
    //     }

    //     $category2 = Category::where('is_active', 1)->get();

}
