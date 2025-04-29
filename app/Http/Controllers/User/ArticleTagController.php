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

    // User context for recent views (if needed later)
    $userId = auth()->id();
    $userIp = request()->ip();

    // 2. Top articles based on recent comments in the past 7 days
    $highlightedArticle = Article::withCount('comments')
        ->where('status', 'published')
        ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->where('created_at', '>=', now()->subDays(7))
        ->orderByDesc('comments_count')
        ->limit(2)
        ->get();

    // 3. Top articles by views in past 7 days
    $highlightedArticleByViews = Article::withCount('comments')
        ->where('status', 'published')
        ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->where('created_at', '>=', now()->subDays(7))
        ->orderByDesc('views')
        ->limit(4)
        ->get();

    // 4. Top articles in last 30 days by comments + views
    $highlightedArticleLast30Days = Article::withCount('comments')
        ->where('status', 'published')
        ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->where('created_at', '>=', now()->subDays(30))
        ->orderByDesc('comments_count')
        ->orderByDesc('views')
        ->limit(5)
        ->get();

    // 5. Latest articles
    $latestArticles = Article::withCount('comments')
        ->where('status', 'published')
        ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->orderByDesc('created_at')
        ->limit(2)
        ->get();

    // 6. Single latest article
    $singleLatestArticle = Article::withCount('comments')
        ->where('status', 'published')
        ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->orderByDesc('created_at')
        ->limit(1)
        ->get();

    // 7. Paginated articles
    $perPage = 4;
    $currentPage = request()->get('page', 1);
    $remainingArticles = Article::withCount('comments')
        ->where('status', 'published')
        ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
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
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->orderByDesc('views')
        ->orderByDesc('created_at')
        ->paginate(8);

    // 9. Tags for sidebar/filter
    $tags = Tag::withCount('publishedArticles')
        ->has('publishedArticles')
        ->orderByDesc('published_articles_count')
        ->paginate(8);

    // 10. Categories for navbar
    $categories = Category::where('is_active', 1)
        ->limit(7)
        ->get();

    $category2 = Category::withCount(['articles' => fn($q) => $q->where('status', 'published')])
        ->where('is_active', 1)
        ->get();

    // 11. Parent categories with children counts
    $parentCategories = Category::whereNull('parent_id')
        ->where('is_active', 1)
        ->withCount(['articles' => fn($q) => $q->where('is_active', 1)])
        ->orderByDesc('articles_count')
        ->paginate(10);

    $parentIds = $parentCategories->pluck('category_id')->toArray();

    $childCategories = Category::whereIn('parent_id', $parentIds)
        ->where('is_active', 1)
        ->withCount(['articles' => fn($q) => $q->where('is_active', 1)])
        ->get()
        ->groupBy('parent_id');

    foreach ($parentCategories as $category) {
        $children = $childCategories[$category->category_id] ?? collect();
        $category->total_articles_count = $category->articles_count + $children->sum('articles_count');
        $category->children = $children;
    }

    // 12. Recent articles (based on user views)
    $recentArticles = Article::where('status', 'published')
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->whereIn('article_id', function ($q) use ($userId, $userIp) {
            $q->select('article_id')
                ->from('article_views')
                ->when($userId, fn($q2) => $q2->where('user_id', $userId))
                ->when(!$userId, fn($q2) => $q2->whereNull('user_id')->where('anonymous', $userIp))
                ->orderByDesc('viewed_at');
        })
        ->limit(4)
        ->get();

    // 13. Related articles based on tag
    $relatedArticles = Article::whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
        ->where('status', 'published')
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
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
        'relatedArticles',
        'recentArticles'
    ));
}

}
