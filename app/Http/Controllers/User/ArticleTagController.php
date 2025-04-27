<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleTagController extends Controller
{
    public function index($tag)
    {
        // 1. Fetch tag information
        $tag = Tag::where('tag_id', $tag)->firstOrFail();

        // Get the authenticated user ID or null if not authenticated
        $userId = auth()->check() ? auth()->id() : null;

        // Get the user's IP address for anonymous users
        $userIp = request()->ip();

        // Initialize exclusion list for article IDs
        $excludedIds = [];

        // 2. Top articles based on recent comments in the past 7 days for the given tag
        $highlightedArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('comments_count')
            ->limit(2)
            ->get();

        // 3. Exclude highlighted articles from the list
        $excludedIds = array_merge($excludedIds, $highlightedArticle->pluck('article_id')->toArray());

        // 4. Articles by views in the past 7 days, excluding the highlighted ones
        $highlightedArticleByViews = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // Add these articles to the exclusion list as well
        $excludedIds = array_merge($excludedIds, $highlightedArticleByViews->pluck('article_id')->toArray());

        // 5. Top articles in the last 30 days by both comments and views
        $highlightedArticleLast30Days = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderByDesc('comments_count')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // Add these articles to the exclusion list as well
        $excludedIds = array_merge($excludedIds, $highlightedArticleLast30Days->pluck('article_id')->toArray());

        // 6. Latest articles excluding the ones already retrieved
        $latestArticles = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('created_at')
            ->limit(2)
            ->get();

        // 7. 1 latest article (excluding the ones already retrieved)
        $singleLatestArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('created_at') // Sort by creation time
            ->limit(1)
            ->get();

        // Add the latest article ID to the exclusion list
        $excludedIds = array_merge($excludedIds, $singleLatestArticle->pluck('article_id')->toArray());

        // 8. Paginate remaining articles by tag
        $perPage = 4; // Articles per page
        $currentPage = request()->get('page', 1); // Current page from request

        $remainingArticles = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id))
            ->whereNotIn('article_id', $excludedIds) // Exclude fetched articles
            ->orderByDesc('created_at')
            ->get();

        // 9. Calculate total articles for pagination
        $totalArticles = $remainingArticles->count();

        // 10. Paginate the articles
        $paginatedArticles = new \Illuminate\Pagination\LengthAwarePaginator(
            $remainingArticles->forPage($currentPage, $perPage), // Articles for current page
            $totalArticles, // Total number of articles
            $perPage, // Number of articles per page
            $currentPage, // Current page
            ['path' => request()->url(), 'query' => request()->query()] // Keep query params
        );

        // 11. Fetch other related articles (same tag but exclude those already fetched)
        $otherArticles = Article::whereHas('tags', fn($query) => $query->where('tags.tag_id', $tag->tag_id))
            ->where('status', 'published')
            ->whereNotIn('article_id', $excludedIds) // Exclude already fetched articles
            ->orderByDesc('views')
            ->orderByDesc('created_at')
            ->paginate(8);

        // 12. Fetch tags and categories for the view
        $tags = Tag::withCount('publishedArticles')
            ->has('publishedArticles')
            ->orderByDesc('published_articles_count')
            ->paginate(8);

        $categories = Category::where('is_active', 1)->limit(7)->get();
        $category2 = Category::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->where('is_active', 1)->get();

        // Parent categories and children
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', 1)
            ->withCount(['articles' => function ($query) {
                $query->where('is_active', 1);
            }])
            ->orderBy('articles_count', 'desc')
            ->paginate(10);

        $parentIds = $parentCategories->pluck('category_id')->toArray();
        $childCategories = Category::whereIn('parent_id', $parentIds)
            ->where('is_active', 1)
            ->withCount(['articles' => function ($query) {
                $query->where('is_active', 1);
            }])
            ->get()
            ->groupBy('parent_id');

        foreach ($parentCategories as $category) {
            $children = $childCategories[$category->category_id] ?? collect();
            $childArticlesCount = $children->sum('articles_count');
            $category->total_articles_count = $category->articles_count + $childArticlesCount;
            $category->children = $children;
        }

       
        $userId = auth()->check() ? auth()->id() : null;
        $userIp = request()->ip();

        $recentArticles = Article::where('status', 'published')

            ->whereIn('article_id', function ($q) use ($userId, $userIp) {
                $q->select('article_id')
                    ->from('article_views')
                    ->when($userId, fn($q2) => $q2->where('user_id', $userId))
                    ->when(!$userId, fn($q2) => $q2->whereNull('user_id')->where('anonymous', $userIp))
                    ->orderByDesc('viewed_at');
            })
            ->limit(10)
            ->get();

        // 3. Fetch related articles based on the same tag, excluding recent ones
        $relatedArticles = Article::whereHas('tags', fn($q) => $q->where('tags.tag_id', $tag->tag_id)) // Filter by tag
            ->where('status', 'published')
            ->whereNotIn('article_id', $recentArticles->pluck('article_id')->toArray())  // Exclude recent articles
            ->orderByDesc('views')  // Order by most viewed
            ->limit(4)  // Limit to 4 related articles
            ->get();



        // 14. Fetch related articles excluding the recent ones
        $relatedArticles = Article::where('status', 'published')
            ->whereNotIn('article_id', $recentArticles->pluck('article_id')->toArray())
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        // Return data to the view
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
            'paginatedArticles'
        ));
    }
}
