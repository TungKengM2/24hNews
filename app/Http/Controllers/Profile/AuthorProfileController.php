<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorProfileController extends Controller
{
    public function show($user_id)
    {
        $user = auth()->user();
        $author = User::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->findOrFail($user_id);

        if ($user->role !== 'admin' && $user->id !== $author->id) {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }

        // Lấy các bài viết của user trong 1 tuần qua
        $articles = Article::where('author_id', $user_id)
            ->where('status', 'published')
            ->where('created_at', '>=', now()->subWeek())
            ->get();

        $totalViews = $articles->sum('views');
        $totalLikes = ArticleLike::whereIn('article_id', $articles->pluck('article_id'))->count();
        $totalComments = Comment::whereIn('article_id', $articles->pluck('article_id'))->count();
        // Tính điểm trung bình
        $totalArticles = max($articles->count(), 1);
        $averageInteraction = ($totalViews + $totalLikes + $totalComments) / $totalArticles;

        $maxScore = 10;
        $ratingStars = min(5, max(1, round(($averageInteraction / $maxScore) * 5)));

        return view('website.profiles.author', compact('author', 'articles', 'ratingStars'));
    }
}
