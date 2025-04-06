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
    public function showAuth($user_id)
    {
        // Lấy thông tin tác giả và số lượng bài viết đã xuất bản
        $author = User::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->findOrFail($user_id);

        // Số người theo dõi
        $followerCount = $author->followers()->count();

        // Lấy danh sách bài viết đã xuất bản của tác giả
        $articles = Article::where('author_id', $user_id)
            ->where('status', 'published')
            ->get();

        // dd($articles);
        $articleIds = $articles->pluck('article_id');

        // Lấy tổng số lượt thích và bình luận của tất cả bài viết
        $likesCounts = ArticleLike::whereIn('article_id', $articleIds)
            ->selectRaw('article_id, COUNT(*) as total_likes')
            ->groupBy('article_id')
            ->pluck('total_likes', 'article_id');

        $commentsCounts = Comment::whereIn('article_id', $articleIds)
            ->selectRaw('article_id, COUNT(*) as total_comments')
            ->groupBy('article_id')
            ->pluck('total_comments', 'article_id');

        // Tính tổng điểm sao
        $totalStars = 0;
        $maxInteractions = 0;

        // Tính tổng tương tác lớn nhất của một bài viết để chuẩn hóa điểm sao
        foreach ($articles as $article) {
            $articleInteractions = ($article->views ?? 0) +
                ($likesCounts[$article->id] ?? 0) +
                ($commentsCounts[$article->id] ?? 0);

            $maxInteractions = max($maxInteractions, $articleInteractions);
        }

        // Tính điểm sao cho từng bài viết dựa trên mức độ phổ biến nhất
        foreach ($articles as $article) {
            $articleInteractions = ($article->views ?? 0) +
                ($likesCounts[$article->id] ?? 0) +
                ($commentsCounts[$article->id] ?? 0);

            // Công thức tối ưu
            $articleStars = $maxInteractions > 0
                ? min(5, 1 + 4 * ($articleInteractions / $maxInteractions))
                : 1; // Nếu không có tương tác, mặc định 1 sao

            $totalStars += $articleStars;
        }

        // Tính trung bình điểm sao
        $averageRating = number_format($totalStars / max($articles->count(), 1), 1);

        return view('website.profiles.author', compact('author', 'articles', 'averageRating', 'followerCount'));
    }

    public function follow(User $user)
    {
        $authUser = auth()->user();

        // Kiểm tra nếu user đang cố follow chính mình
        if ($authUser->user_id === $user->user_id) {
            return back()->with('error', 'Bạn không thể tự follow chính mình!');
        }

        // Kiểm tra nếu đã follow rồi
        if (!$authUser->following()->where('following_id', $user->user_id)->exists()) {
            $authUser->following()->attach($user->user_id);
            return back()->with('success', 'Bạn đã follow ' . $user->username);
        }

        return back()->with('error', 'Bạn đã follow người này rồi!');
    }

    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user->user_id);
        return back()->with('success', 'Bạn đã unfollow ' . $user->username);
    }
}
