<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleLike;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleHistory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        // $articles = Article::latest()->get();


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



 
    
    
    
    
}
