<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleUserController extends Controller
{
    public function show($article_id)
    {
        $article = Article::where('article_id', $article_id)->first();

        if (!$article) {
            abort(404, 'Bài viết không tồn tại!');
        }

        $userId = auth()->id();

        // Kiểm tra xem user đã like bài viết chưa
        $isLiked = false;
        if ($userId) {
            $isLiked = ArticleLike::where('article_id', $article->article_id)
                ->where('user_id', $userId)
                ->exists();
        }

        // Lấy số lượt like
        $likeCount = ArticleLike::where('article_id', $article->article_id)->count();

        // Lấy bài viết liên quan
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('article_id', '!=', $article->article_id)
            ->limit(5)
            ->get();

        return view('client.articles.article', compact('article', 'relatedArticles', 'isLiked', 'likeCount'));
    }

    public function likeArticle(Request $request, $article_id)
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để like!']);
        }

        $like = ArticleLike::where('article_id', $article_id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            try {
                ArticleLike::where('like_id', $like->like_id)->delete(); // Xóa theo đúng khóa chính
                $liked = false;
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Lỗi khi hủy like: ' . $e->getMessage()]);
            }
        } else {
            ArticleLike::create([
                'article_id' => $article_id,
                'user_id' => $userId,
                'liked_at' => now(),
            ]);
            $liked = true;
        }

        $likeCount = ArticleLike::where('article_id', $article_id)->count();

        return response()->json(['success' => true, 'liked' => $liked, 'likeCount' => $likeCount]);
    }
}
