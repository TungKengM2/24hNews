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
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->limit(5)
            ->get();



        // Lấy bài viết nhiều lượt xem nhất có tag này
        $articlesViews = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->paginate(4);

        // Lấy danh sách bài viết có tag này
        $tags = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();
            $articleIds = $articlesViews->pluck('article_id'); // Thay vì 'id', dùng 'article_id'

            $otherArticles = Article::whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.tag_id', $tag->tag_id);
            })
            ->where('status', 'published')
            ->whereNotIn('article_id', $articleIds) // Thay vì 'id', dùng 'article_id'
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->paginate(8);

       

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
            'otherArticles',
            'tags'
        ));
    }
}
