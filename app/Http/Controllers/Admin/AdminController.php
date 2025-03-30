<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
