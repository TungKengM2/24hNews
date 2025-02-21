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

    // Ghi nhận lượt xem
    try {
        ArticleView::create([
            'article_id' => $article->article_id,
            'user_id' => auth()->id(),
            'anonymous' => auth()->check() ? 0 : 1,
            'viewed_at' => now(),
        ]);
    } catch (\Exception $e) {
        report($e);
    }

    // Lấy bài viết liên quan
    $relatedArticles = Article::where('category_id', $article->category_id)
                              ->where('article_id', '!=', $article->article_id)
                              ->limit(5)
                              ->get();

    return view('client.articles.article', compact('article', 'relatedArticles'));
}

}


    

