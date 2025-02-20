<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy tối đa 3 bài viết mới nhất
        $latestArticles = Article::latest()->take(3)->get();

        // Lấy tối đa 7 bài viết theo danh mục thể thao (giả định category_id = 1 là thể thao)
        $sportsArticles = Article::where('category_id', 1)->latest()->take(7)->get();

        // Truyền dữ liệu bài viết tới view
        return view('website.pages.home.home', compact('latestArticles', 'sportsArticles'));
    }
}
