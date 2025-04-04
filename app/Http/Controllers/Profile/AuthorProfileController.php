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
        // Xóa kiểm tra user đăng nhập vì người dùng đang cần xem profile tác giả mà không cần đăng nhập
        
        // Tìm người dùng theo ID và đếm số lượng bài viết đã xuất bản
        $author = User::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->findOrFail($user_id);

        // Bỏ kiểm tra quyền truy cập để mọi người đều có thể xem profile tác giả
        // if ($user->role !== 'admin' && $user->id !== $author->id) {
        //     abort(403, 'Bạn không có quyền truy cập trang này!');
        // }

        // Số người theo dõi
        $followerCount = $author->followers()->count();

        // Lấy tất cả bài viết
        $articles = Article::where('author_id', $user_id)
            ->where('status', 'published')
            ->get();

        $articleIds = $articles->pluck('id'); // Sửa từ article_id thành id vì đây là collection các Article

        // Tính tổng tương tác trước để tránh N+1 Query
        $likesCount = ArticleLike::whereIn('article_id', $articleIds)->count();
        $commentsCount = Comment::whereIn('article_id', $articleIds)->count();
        $totalViews = $articles->sum('views');

        $maxScore = 100;
        $totalStars = 0;

        foreach ($articles as $article) {
            $articleInteractions = ($article->views ?? 0) +
                ArticleLike::where('article_id', $article->id)->count() +
                Comment::where('article_id', $article->id)->count();

            $articleStars = min(5, max(1, ($articleInteractions / $maxScore) * 5));
            $totalStars += $articleStars;
        }

        // Tính trung bình rating sao của tất cả bài viết, đảm bảo không chia cho 0
        $totalArticles = max($articles->count(), 1);
        $averageRating = number_format($totalStars / $totalArticles, 1);
        
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
