<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use App\Models\ArticleView;

class CategoryUserController extends Controller
{
    public function index($slug, $childSlug = null)
    {
        // 1. Xác định category (cha hoặc con)
        if ($childSlug) {
            // Đang truy cập danh mục con
            $category = Category::with(['parent', 'children'])
                ->where('slug', $childSlug)
                ->whereHas('parent', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })
                ->firstOrFail();
        } else {
            // Đang truy cập danh mục cha
            $category = Category::with(['parent', 'children'])
                ->where('slug', $slug)
                ->whereNull('parent_id')
                ->firstOrFail();
        }

        // 2. Tập hợp ID của category hiện tại và các con
        $categoryIds = $category->children->pluck('category_id')->push($category->category_id);

        // 3. Breaking news (3 bài mới nhất)
        $breakingNews = Article::where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1)
                ->whereIn('category_id', $categoryIds))
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        // 4. Closure chọn bài nổi bật (không phân biệt 7 ngày)
        $selectTop = fn(array $exclude = []) => Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1)
                ->whereIn('category_id', $categoryIds))
            ->whereNotIn('article_id', collect($exclude)
                ->merge($breakingNews->pluck('article_id')))
            ->orderByDesc('comments_count')
            ->orderByDesc('created_at')
            ->limit(1)
            ->first();

        // 5. Highlighted article
        $highlightedArticle = $selectTop();

        // Fallback nếu không có
        if (! $highlightedArticle) {
            $highlightedArticle = Article::withCount('comments')
                ->where('status', 'published')
                ->whereHas('category', fn($q) => $q->where('is_active', 1)
                    ->whereIn('category_id', $categoryIds))
                ->whereNotIn('article_id', $breakingNews->pluck('article_id'))
                ->orderByDesc('created_at')
                ->limit(1)
                ->first();
        }

        // 6. Secondary article
        $highlightedId = optional($highlightedArticle)->article_id;
        $secondaryArticle = $selectTop([$highlightedId]);

        // Fallback nếu không có
        if (! $secondaryArticle) {
            $secondaryArticle = Article::withCount('comments')
                ->where('status', 'published')
                ->whereHas('category', fn($q) => $q->where('is_active', 1)
                    ->whereIn('category_id', $categoryIds))
                ->whereNotIn('article_id', array_filter([
                    $highlightedId,
                    ...$breakingNews->pluck('article_id')->toArray(),
                ]))
                ->orderByDesc('created_at')
                ->limit(1)
                ->first();
        }

        // 7. Ba bài Nebula Nuggets
        $excludedIds = collect([
            optional($highlightedArticle)->article_id,
            optional($secondaryArticle)->article_id,
        ])->merge($breakingNews->pluck('article_id'))
            ->filter()
            ->unique();

        $nebulaNuggets = Article::withCount('comments')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1)
                ->whereIn('category_id', $categoryIds))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('comments_count')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        // 8. Năm bài xem nhiều nhất
        $mostViewedArticles = Article::where('status', 'published')
            ->whereNotIn('article_id', $excludedIds)
            ->whereHas('category', fn($q) => $q->where('is_active', 1)
                ->whereIn('category_id', $categoryIds))
            ->orderByDesc('views')
            ->take(6)
            ->get();

        $topMainArticle = $mostViewedArticles->take(2);
        $topSideArticles = $mostViewedArticles->slice(2);

        // 9. Các query khác giữ nguyên
        $articlesNews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        $articles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->orderByDesc('created_at')
            ->paginate(10);

        $articlesViews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->orderByDesc('views')
            ->orderByDesc('created_at')
            ->distinct()
            ->paginate(4);

        $featuredArticle = Article::with('category')
            ->where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->limit(4)
            ->first();

        $categories = Category::withCount([
            'articles as articles_count'       => fn($q) => $q->where('status', 'published'),
            'subArticles as sub_articles_count' => fn($q) => $q->where('status', 'published'),
        ])
            ->where('is_active', 1)
            ->orderByRaw('articles_count + sub_articles_count DESC')
            ->take(6)
            ->get();


        // Lấy parent categories cho menu
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', 1)
            ->withCount(['articles' => fn($q) => $q->where('status', 'published')])
            ->orderByDesc('articles_count')
            ->paginate(10);

        $parentIds = $parentCategories->pluck('category_id')->toArray();
        $childCategories = Category::whereIn('parent_id', $parentIds)
            ->where('is_active', 1)
            ->withCount(['articles' => fn($q) => $q->where('status', 'published')])
            ->get()
            ->groupBy('parent_id');

        foreach ($parentCategories as $parentCat) {
            $children = $childCategories[$parentCat->category_id] ?? collect();
            $childArticlesCount = $children->sum('articles_count');
            $parentCat->total_articles_count = $parentCat->articles_count + $childArticlesCount;
            $parentCat->children = $children;
        }

        // Tags
        $tags = Tag::withCount('publishedArticles')
            ->has('publishedArticles')
            ->orderByDesc('published_articles_count')
            ->paginate(8);

        // View history
        $userId = auth()->check() ? auth()->id() : null;
        $userIp = request()->ip();
        $viewedArticleIds = ArticleView::where(function ($q) use ($userId, $userIp) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->whereNull('user_id')->where('anonymous', $userIp);
            }
        })
            ->orderByDesc('viewed_at')
            ->pluck('article_id');

        $recentArticles = Article::where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1)
                ->whereIn('category_id', $categoryIds))
            ->where('article_id', '!=', optional($highlightedArticle)->article_id)
            ->whereIn('article_id', function ($q) use ($userId, $userIp) {
                $q->select('article_id')
                    ->from('article_views')
                    ->when($userId, fn($q2) => $q2->where('user_id', $userId))
                    ->when(!$userId, fn($q2) => $q2->whereNull('user_id')->where('anonymous', $userIp))
                    ->orderByDesc('viewed_at');
            })
            ->limit(4)
            ->get();

        $relatedArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereNotIn('article_id', $recentArticles->pluck('article_id')->toArray())
            ->where('article_id', '!=', optional($featuredArticle)->article_id)
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        // Trả về view
        return view('website.categories.categories', [
            'parentCategories'    => $parentCategories,
            'relatedArticles'     => $relatedArticles,
            'recentArticles'      => $recentArticles,
            'tags'                => $tags,
            'categories'          => $categories,
            'articlesNews'        => $articlesNews,
            'category'            => $category,
            'category2'           => Category::all(),
            'articles'            => $articles,
            'articlesViews'       => $articlesViews,
            'featuredArticle'     => $featuredArticle,
            'breakingNews'        => $breakingNews,
            'highlightedArticle'  => $highlightedArticle,
            'secondaryArticle'    => $secondaryArticle,
            'nebulaNuggets'       => $nebulaNuggets,
            'topSideArticles'     => $topSideArticles,
            'topMainArticle'      => $topMainArticle,
        ]);
    }
}
