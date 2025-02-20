<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class AuthorDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:author');
    }

    public function index()
    {
        $user = Auth::user();
        $articleStats = [
            'total' => Article::where('author_id', $user->user_id)->count(),
            'published' => Article::where('author_id', $user->user_id)
                ->where('status', 'published')
                ->count(),
            'pending' => Article::where('author_id', $user->user_id)
                ->where('status', 'pending'),
            'draft' => Article::where('author_id', $user->user_id)
                ->where('status', 'draft'),
        ];

        return view('author.dashboard', compact('articleStats'));
    }
}
