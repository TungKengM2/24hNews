<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleTagController extends Controller
{
    public function index($tag)
    {
        // 1. Fetch tag information
        $tag = Tag::where('tag_id', $tag)->firstOrFail();

        $userId = auth()->id();
        $userIp = request()->ip();
        $excludedIds = [];

        // 2. Top articles based on recent comments in the past 7 days
        $highlightedArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('comments_count')
            ->limit(2)
            ->get();
        $excludedIds = array_merge($excludedIds, $highlightedArticle->pluck('article_id')->toArray());

        // 3. Top articles by views in past 7 days
        $highlightedArticleByViews = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('views')
            ->limit(5)
            ->get();
        $excludedIds = array_merge($excludedIds, $highlightedArticleByViews->pluck('article_id')->toArray());

        // 4. Top articles in last 30 days by comments + views
        $highlightedArticleLast30Days = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderByDesc('comments_count')
            ->orderByDesc('views')
            ->limit(5)
            ->get();
        $excludedIds = array_merge($excludedIds, $highlightedArticleLast30Days->pluck('article_id')->toArray());

        // 5. Latest articles excluding the above
        $latestArticles = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('created_at')
            ->limit(2)
            ->get();
        $excludedIds = array_merge($excludedIds, $latestArticles->pluck('article_id')->toArray());

        // 6. Single latest article
        $singleLatestArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();
        $excludedIds = array_merge($excludedIds, $singleLatestArticle->pluck('article_id')->toArray());

        // 7. Paginated articles
        $perPage = 4;
        $currentPage = request()->get('page', 1);
        $remainingArticles = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('created_at')
            ->get();
        $paginatedArticles = new LengthAwarePaginator(
            $remainingArticles->forPage($currentPage, $perPage),
            $remainingArticles->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // 8. Other articles (sidebar)
        $otherArticles = Article::whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->where('status', 'published')
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('views')
            ->orderByDesc('created_at')
            ->paginate(8);

        // 9. Tags
        $tags = Tag::withCount('publishedArticles')
            ->has('publishedArticles')
            ->orderByDesc('published_articles_count')
            ->paginate(8);

        // 10. Categories
        $categories = Category::where('is_active', 1)->limit(7)->get();
        $category2 = Category::withCount(['articles' => function ($q) {
            $q->where('status', 'published');
        }])->where('is_active', 1)->get();

        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', 1)
            ->withCount(['articles' => function ($q) {
                $q->where('is_active', 1);
            }])
            ->orderBy('articles_count', 'desc')
            ->paginate(10);

        $parentIds = $parentCategories->pluck('category_id')->toArray();
        $childCategories = Category::whereIn('parent_id', $parentIds)
            ->where('is_active', 1)
            ->withCount(['articles' => function ($q) {
                $q->where('is_active', 1);
            }])
            ->get()
            ->groupBy('parent_id');

        foreach ($parentCategories as $category) {
            $children = $childCategories[$category->category_id] ?? collect();
            $category->total_articles_count = $category->articles_count + $children->sum('articles_count');
            $category->children = $children;
        }

        $userId = auth()->check() ? auth()->id() : null;
        $userIp = request()->ip();

        $recentArticles = Article::where('status', 'published')
            ->whereIn('article_id', function ($q) use ($userId, $userIp) {
                $q->select('article_id')  // Sử dụng 'article_id' thay vì 'id'
                    ->from('article_views')
                    ->when($userId, function ($query) use ($userId) {
                        $query->where('user_id', $userId);  // Nếu người dùng đã đăng nhập
                    })
                    ->when(!$userId, function ($query) use ($userIp) {
                        $query->whereNull('user_id')
                            ->where('anonymous', $userIp);  // Nếu người dùng chưa đăng nhập, sử dụng IP
                    })
                    ->orderByDesc('viewed_at');  // Sắp xếp theo thời gian xem bài viết
            })
            ->limit(10)
            ->get();

      





        // 12. Related articles (based on tag, exclude recent viewed)
        $relatedArticles = Article::where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->whereNotIn('article_id', $recentArticles->pluck('article_id'))
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        // Return view
        return view('website.articles.tag', compact(
            'categories',
            'category2',
            'parentCategories',
            'tag',
            'tags',
            'highlightedArticle',
            'highlightedArticleByViews',
            'highlightedArticleLast30Days',
            'latestArticles',
            'otherArticles',
            'singleLatestArticle',
            'paginatedArticles',
            'relatedArticles'
        ));
    }
}
