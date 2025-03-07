<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        //breaking news
        $featuredArticles = Article::where('status', 'published')
            ->orderByDesc('created_at') // Sắp xếp theo thời gian mới nhất
            ->take(7)
            ->get();

        //top 2 bài viết nhiều lượt xem
        $D1Articles = Article::where('status', 'published')
            ->orderByDesc('views') // Sắp xếp bài viết nhiều views nhất
            ->take(2) // Lấy top 2 bài viết nhiều lượt xem
            ->get();

        // Lấy danh sách bài viết mới nhất
        $articles = Article::where('status', 'published')->latest()->get();

        $trendingPosts = Article::select('articles.*')
            ->join('comments', 'articles.article_id', '=', 'comments.article_id')
            ->selectRaw('COUNT(comments.comment_id) as comment_count')
            ->groupBy('articles.article_id')
            ->orderByDesc('comment_count')
            ->limit(5)
            ->get();

        $journalists = User::where('role_id', 3)->get(); // Lấy nhà báo có ID = 3


        $sportsArticles = Article::whereHas('category', function ($query) {
            $query->where('name', 'Thể Thao'); // Hoặc sử dụng category_id cụ thể
        })->inRandomOrder()->distinct()->get();



        //11111111
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
                    'article' => $article
                ];
            }
        }

        $categories = Category::where('is_active', 1)->get();
                
        // Truyền dữ liệu bài viết tới view
        return view('welcome', compact('categories','sportsArticles', 'newsData', 'journalists', 'trendingPosts', 'featuredArticles', 'articles', 'D1Articles'));
    }
    


    public function getPostsByCategory(Request $request) {
        $categoryId = $request->category_id;
    
        if (!$categoryId) {
            return response()->json(['error' => 'Danh mục không hợp lệ'], 400);
        }
    
        $posts = Article::where('category_id', $categoryId) // ✅ Đúng: Lấy từ bảng `articles`
            ->where('status', 'published') // ✅ Đúng: `status` có trong bảng `articles`
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($post) {
                return [
                    'slug' => $post->slug,
                    'title' => $post->title,
                    'preview_content' => $post->preview_content,
                    'thumbnail_url' => asset('storage/' . $post->thumbnail_url),
                    'category_name' => $post->category->name ?? 'Không xác định',
                    'created_at' => $post->created_at->format('d/m/Y H:i'),
                ];
            });
    
        return response()->json($posts);
    }
    
    
}
    
    
    


    


  
    
    
    

