<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        //breaking news
        $featuredArticles = Article::where('status', 'published')
        ->orderByDesc('created_at') // Sắp xếp theo thời gian mới nhất
        ->take(7)
        ->get();

        // hot trends
        

        //
        $D1Articles = Article::where('status', 'published')
        ->orderByDesc('created_at') // Sắp xếp bài viết mới nhất
        ->take(2) // Lấy 2 bài viết gần đây
        ->get();
    
        // Lấy danh sách bài viết mới nhất
        $articles = Article::where('status', 'published')->latest()->get();
    
   
        // Truyền dữ liệu bài viết tới view
        return view('welcome', compact('featuredArticles', 'articles', 'D1Articles'));

    }
}
