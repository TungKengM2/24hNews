<?php

namespace App\Http\Controllers\User;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleTagController extends Controller
{
    public function index($tag)
    {
        // Lấy thông tin tag
        $tag = Tag::where('tag_id', $tag)->firstOrFail();

        // Lấy bài viết mới nhất có tag này
        $articlesNews = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();



        // Lấy bài viết nhiều lượt xem nhất có tag này
        $articlesViews = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        // Lấy danh sách bài viết có tag này
        $tags = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        // Lấy bài viết nổi bật nhất (nhiều view nhất) trong tag
        $featuredArticle = Article::with('tags') // Load cả tag
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.tag_id', $tag->tag_id);
            })
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->first();

        // Lấy 5 bài viết liên quan (không trùng bài nổi bật)
        $relatedArticles = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->where('article_id', '!=', optional($featuredArticle)->article_id)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        // Lấy tất cả tags
        $tags = Tag::all();

        $categories = Category::where('is_active', 1)->limit(7)->get();
        $category2 = Category::where('is_active', 1)->get();

        return view('website.articles.tag', compact(
            'categories',
            'category2',
            'tag',
            'tags',
            'articlesNews',
            'articlesViews',
            'featuredArticle',
            'relatedArticles',
            'tags'
        ));
    }
}
