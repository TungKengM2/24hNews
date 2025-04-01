<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getUserComments($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }


        $comments = Comment::where('user_id', $userId)
            ->whereNotNull('article_id')
            ->with('article')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.comments', compact('user', 'comments'));
    }

    // dat them
    public function dashboard()
    {
        // Thống kê bài viết
        $articleStats = [
            'total' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'pending' => Article::where('status', 'pending')->count(),
            'draft' => Article::where('status', 'draft')->count(),
        ];

        // Lấy các bài viết gần đây
        $recentArticles = Article::with('author')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Các dữ liệu khác cho biểu đồ thống kê
        // ... code hiện tại của bạn ...

        return view('admin.dashboard', compact(
            'articleStats',
            'recentArticles'
            // ... các biến khác bạn đã có ...
        ));
    }
}
