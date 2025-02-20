<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
<<<<<<< HEAD
use App\Models\ArticleLike;
use Illuminate\Support\Str;
=======
>>>>>>> c4fb09e72b4073f0818a85d1413b6074debe5c8d
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy tối đa 3 bài viết mới nhất
        $latestArticles = Article::latest()->take(3)->get();


<<<<<<< HEAD
        // return view('welcome', compact('articles'));
        return view('welcome');
        // Lấy bài viết có nhiều lượt xem và lượt thích nhất
        $featuredArticle = Article::where('status', 'published')
        ->orderByDesc('views') // Sắp xếp theo lượt xem giảm dần
        ->first();
    
        // Lấy danh sách bài viết mới nhất
        $articles = Article::where('status', 'published')->latest()->get();
    
        return view('welcome', compact('featuredArticle', 'articles'));
    }
    public function likeArticle($article_id)
    {
        $user = auth()->user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thích bài viết.');
        }
    
        $like = ArticleLike::where('article_id', $article_id)->where('user_id', $user->id)->first();
    
        if ($like) {
            $like->delete();
            return back()->with('message', 'Bạn đã bỏ thích bài viết.');
        } else {
            ArticleLike::create([
                'article_id' => $article_id,
                'user_id' => $user->id,
            ]);
            return back()->with('success', 'Bạn đã thích bài viết!');
        }
    }



 
    
    
    
    
=======
        $categoryArticles = Article::where('category_id', 1)->latest()->take(7)->get();

        // Truyền dữ liệu bài viết tới view
        return view('website.pages.home.home', compact('latestArticles', 'categoryArticles'));
    }
>>>>>>> c4fb09e72b4073f0818a85d1413b6074debe5c8d
}
