<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorProfileController extends Controller
{
    public function show($user_id)
    {
        $user = auth()->user();
        $author = User::withCount('articles')->with('articles')->findOrFail($user_id);

        // Tính trung bình lượt tương tác trong 7 ngày qua
        $oneWeekAgo = now()->subDays(7);
        $articles = $author->articles()->where('created_at', '>=', $oneWeekAgo)->get();
        $totalInteractions = $articles->sum(function ($article) {
            return $article->likes_count + $article->comments_count + $article->views_count;
        });

        $averageInteractions = $articles->count() > 0 ? $totalInteractions / $articles->count() : 0;

        // Tính số sao dựa trên mức trung bình
        $maxRating = 5; // 5 sao tối đa
        $threshold = 100; // Giới hạn tối đa để đạt 5 sao
        $rating = min($maxRating, ($averageInteractions / $threshold) * $maxRating);

        return view('website.profiles.author', compact('author', 'rating'));
    }
}
