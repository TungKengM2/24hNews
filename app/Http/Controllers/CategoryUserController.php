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
        // Debug thông tin nhận được
        \Log::info('CategoryUserController::index', [
            'slug' => $slug,
            'childSlug' => $childSlug
        ]);

        // 1. Xác định category hiện tại
        if ($childSlug) {
            $category = Category::with(['parent', 'children'])
                ->where('slug', $childSlug)
                ->whereHas('parent', fn($q) => $q->where('slug', $slug))
                ->firstOrFail();

            // Debug thông tin category con
            \Log::info('Child category found', [
                'category_id' => $category->category_id,
                'name' => $category->name,
                'parent_id' => $category->parent_id,
                'parent_name' => $category->parent->name ?? 'No parent'
            ]);
        } else {
            $category = Category::with(['parent', 'children'])
                ->where('slug', $slug)
                ->whereNull('parent_id')
                ->firstOrFail();

            // Debug thông tin category cha
            \Log::info('Parent category found', [
                'category_id' => $category->category_id,
                'name' => $category->name,
                'children_count' => $category->children->count()
            ]);
        }

        // 2. Lấy IDs của category hiện tại và các con
        $categoryIds = $category->children->pluck('category_id')->push($category->category_id);

        // 3. Viết 1 hàm để filter đúng theo cha/con
        $whereCategory = function ($query) use ($categoryIds, $childSlug) {
            if ($childSlug) {
                $query->whereIn('subcategory_id', $categoryIds);
            } else {
                $query->whereIn('category_id', $categoryIds);
            }
        };

        // 1. Top bài viết nổi bật (nhiều comment nhất trong 7 ngày)
        $highlightedArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->where($whereCategory)
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('comments_count')
            ->limit(2)
            ->get();

        // 2. Top bài viết theo views (vẫn trong 7 ngày)
        $highlightedArticleByViews = Article::withCount('comments')
            ->where('status', 'published')
            ->where($whereCategory)
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        // 3. Top bài viết nổi bật trong 30 ngày (bình luận + views)
        $highlightedArticleLast30Days = Article::withCount('comments')
            ->where('status', 'published')
            ->where($whereCategory)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderByDesc('comments_count')
            ->orderByDesc('views')
            ->limit(5)
            ->get();




            $articles = Article::with('category', 'comments')
            ->withCount('comments')
            ->where('status', 'published')
            ->where($whereCategory)
            ->orderByDesc('created_at')
            ->paginate(10); // hoặc get() nếu bạn không cần phân trang










        // 5. Các dữ liệu khác (categories, tags, history, related)

        $categories = Category::withCount([
            'articles as articles_count' => fn($q) => $q->where('status', 'published'),
            'subArticles as sub_articles_count' => fn($q) => $q->where('status', 'published')
        ])
            ->where('is_active', 1)
            ->orderByRaw('articles_count + sub_articles_count DESC')
            ->take(6)
            ->get();

        // phân trang parentCategories
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', 1)
            ->withCount(['articles' => fn($q) => $q->where('status', 'published')])
            ->orderByDesc('articles_count')
            ->paginate(10, ['*'], 'categories_page');

        $parentIds = $parentCategories->pluck('category_id')->toArray();
        $childCategories = Category::whereIn('parent_id', $parentIds)
            ->where('is_active', 1)
            ->withCount(['articles' => fn($q) => $q->where('status', 'published')])
            ->get()
            ->groupBy('parent_id');

        foreach ($parentCategories as $parentCat) {
            $children = $childCategories[$parentCat->category_id] ?? collect();
            $parentCat->total_articles_count = $parentCat->articles_count + $children->sum('articles_count');
            $parentCat->children = $children;
        }

        // phân trang tags
        $tags = Tag::withCount('publishedArticles')
            ->has('publishedArticles')
            ->orderByDesc('published_articles_count')
            ->paginate(8, ['*'], 'tags_page');



        $userId = auth()->check() ? auth()->id() : null;
        $userIp = request()->ip();

        $recentArticles = Article::where('status', 'published')
            ->where(function ($q) use ($whereCategory) {
                $whereCategory($q);
            })
            ->whereIn('article_id', function ($q) use ($userId, $userIp) {
                $q->select('article_id')
                    ->from('article_views')
                    ->when($userId, fn($q2) => $q2->where('user_id', $userId))
                    ->when(!$userId, fn($q2) => $q2->whereNull('user_id')->where('anonymous', $userIp))
                    ->orderByDesc('viewed_at');
            })
            ->limit(4)
            ->get();

        $relatedArticles = Article::where(function ($q) use ($whereCategory) {
            $whereCategory($q);
        })
            ->where('status', 'published')
            ->whereNotIn('article_id', $recentArticles->pluck('article_id')->toArray())
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        return view('website.categories.categories', [
            'parentCategories' => $parentCategories,
            'articles'  => $articles,
            'relatedArticles' => $relatedArticles,
            'recentArticles' => $recentArticles,
            'tags' => $tags,
            'categories' => $categories,
            'category' => $category,
            'category2' => Category::all(),
            'highlightedArticle' => $highlightedArticle,
            'highlightedArticleByViews' => $highlightedArticleByViews,

            'highlightedArticleLast30Days' => $highlightedArticleLast30Days
        ]);
    }
}
