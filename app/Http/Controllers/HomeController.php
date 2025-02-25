<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 3 bài viết mới nhất đã được duyệt
        $latestArticles = Article::where('status', 'Published')
            ->latest()
            ->take(3)
            ->get();

        // Lấy 7 bài viết theo danh mục (chỉ lấy bài đã duyệt)
        $categoryArticles = Article::where('category_id', 1)
            ->where('status', 'Published')
            ->latest()
            ->take(7)
            ->get();

        // Truyền dữ liệu bài viết tới view
        return view('website.pages.home.home', compact('latestArticles', 'categoryArticles'));
    }
}
