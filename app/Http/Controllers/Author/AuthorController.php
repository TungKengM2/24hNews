<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function getUserComments($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Lấy bình luận của user có kèm bài viết
        $comments = Comment::where('user_id', $userId)
            ->whereNotNull('article_id') // Đảm bảo có bài viết
            ->with('article') // Load bài viết liên quan
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('author.comments', compact('user', 'comments'));
    }
}
