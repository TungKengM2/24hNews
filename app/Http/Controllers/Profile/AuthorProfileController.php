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

        // Lấy tất cả bài viết đã xuất bản của tác giả
        $articles = Article::where('author_id', $user_id)
            ->where('status', 'published')
            ->get();

        // Tính trung bình rating_star đã được xử lý từ accessor
        $totalStars = $articles->sum(function ($article) {
            return $article->rating_star; // accessor tự tính dựa vào interaction_score
        });

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
    // dat them hiển thị profile user

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        
        return view('website.profiles.user', compact('user'));
    }

    public function getTopAuthors($limit = 5)
    {
        // Lấy tất cả tác giả có ít nhất 3 bài viết đã xuất bản
        $authors = User::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])
        ->having('articles_count', '>=', 3)
        ->get();

        // Tính điểm trung bình cho mỗi tác giả
        $ratedAuthors = $authors->map(function ($author) {
            // Lấy bài viết đã xuất bản của tác giả
            $articles = Article::where('author_id', $author->user_id)
                ->where('status', 'published')
                ->get();
            
            // Tính tổng điểm đánh giá
            $totalStars = $articles->sum(function ($article) {
                return $article->rating_star;
            });
            
            // Tính điểm trung bình
            $averageRating = number_format($totalStars / max($articles->count(), 1), 1);
            
            return [
                'author' => $author,
                'rating' => $averageRating,
                'articles_count' => $articles->count(),
                'specializes_in' => $this->getAuthorSpecialization($author->user_id)
            ];
        })
        ->sortByDesc('rating')
        ->take($limit)
        ->values();

        return $ratedAuthors;
    }

    // Hàm phụ để xác định chuyên môn của tác giả
    private function getAuthorSpecialization($authorId)
    {
        // Lấy danh mục mà tác giả viết nhiều bài nhất
        $topCategory = Article::where('author_id', $authorId)
            ->where('status', 'published')
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->select('categories.name')
            ->groupBy('categories.name')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        return $topCategory ? $topCategory->name : 'Chưa xác định';
    }

    // Sửa lại HomeController để hiển thị tác giả nổi bật
    public function index()
    {
        // ... code khác ...

        // Lấy top tác giả
        $topAuthors = $this->getTopAuthors(5);

        return view('welcome', compact('topAuthors', /* các biến khác */));
    }
}
