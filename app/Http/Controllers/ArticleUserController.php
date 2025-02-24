<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleUserController extends Controller
{
    public function show($article_id)
    {
        // Lấy bài viết theo article_id
        $article = Article::where('article_id', $article_id)->first();

        if (!$article) {
            abort(404, 'Bài viết không tồn tại!');
        }

        // Kiểm tra nếu user đã xem bài viết trước đó
        $userId = auth()->id();
        $hasViewed = ArticleView::where('article_id', $article->article_id)
                                ->where(function ($query) use ($userId) {
                                    if ($userId) {
                                        $query->where('user_id', $userId);
                                    } else {
                                        $query->whereNull('user_id')->where('ip_address', request()->ip());
                                    }
                                })
                                ->exists();
        
        if (!$hasViewed) {
            try {
                ArticleView::create([
                    'article_id' => $article->article_id,
                    'user_id' => $userId,
                    'anonymous' => auth()->check() ? 0 : 1,
                    'ip_address' => request()->ip(),
                    'viewed_at' => now(),
                ]);
                
                // Đảm bảo tăng số lượt xem
                $article->views = $article->views + 1;
                $article->save();
            } catch (\Exception $e) {
                report($e);
            }
        }

        // Lấy bài viết liên quan
        $relatedArticles = Article::where('category_id', $article->category_id)
                                  ->where('article_id', '!=', $article->article_id)
                                  ->limit(5)
                                  ->get();

        return view('client.articles.article', compact('article', 'relatedArticles'));
    }
}