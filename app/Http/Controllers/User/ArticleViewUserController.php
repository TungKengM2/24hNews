<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleViewUserController extends Controller
{
    // Lấy danh sách bài viết đã xem
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user_id = Auth::id();
        // dat them
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        $viewedArticles = ArticleView::where('user_id', $user_id)
            ->with('article')
            ->orderBy('viewed_at', 'desc')
            ->paginate(6);
        // dat them
            return view('website.profiles.users.viewed-acticles', compact('viewedArticles', 'user'));
    }
    // Lưu bài viết đã xem
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Kiểm tra xem request có article_id không
        if (!$request->has('article_id')) {
            return response()->json(['message' => 'Thiếu thông tin bài viết'], 400);
        }

        $user_id = Auth::id();
        $article_id = $request->article_id;

        // Kiểm tra xem bài viết có tồn tại không
        $articleExists = Article::where('article_id', $article_id)->exists();
        if (!$articleExists) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }

        // Kiểm tra xem user đã xem bài viết này chưa
        $existingView = ArticleView::where('user_id', $user_id)
            ->where('article_id', $article_id)
            ->first();

        if (!$existingView) {
            ArticleView::create([
                'user_id' => $user_id,
                'article_id' => $article_id,
                'viewed_at' => now(), // Lưu thời gian xem
            ]);
        }

        return response()->json(['message' => 'Article view recorded']);
    }
}
