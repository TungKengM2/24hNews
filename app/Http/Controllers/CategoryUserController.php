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
        // 1. Xác định category hiện tại
        if ($childSlug) {
            $category = Category::with(['parent', 'children'])
                ->where('slug', $childSlug)
                ->whereHas('parent', fn($q) => $q->where('slug', $slug))
                ->firstOrFail();
        } else {
            $category = Category::with(['parent', 'children'])
                ->where('slug', $slug)
                ->whereNull('parent_id')
                ->firstOrFail();
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

        // Danh sách ID bài viết đã lấy, để loại trừ
        $excludedIds = [];

        // 1. Top bài viết nổi bật (nhiều comment nhất trong 7 ngày)
        $highlightedArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->where(function ($q) use ($whereCategory) {
                $whereCategory($q);
            })
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('comments_count')
            ->limit(2)
            ->get();

        // Lưu các ID bài viết đã lấy vào danh sách loại trừ
        $excludedIds = array_merge($excludedIds, $highlightedArticle->pluck('article_id')->toArray());

        // 2. Top bài viết theo views (loại trừ những bài đã lấy ở trên)
        $highlightedArticleByViews = Article::withCount('comments')
            ->where('status', 'published')
            ->where(function ($q) use ($whereCategory) {
                $whereCategory($q);
            })
            ->where('created_at', '>=', now()->subDays(7))
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // Lưu các ID bài viết đã lấy vào danh sách loại trừ
        $excludedIds = array_merge($excludedIds, $highlightedArticleByViews->pluck('article_id')->toArray());

        // 3. Top bài viết nổi bật (nhiều comment nhất và views cao nhất trong 30 ngày)
        $highlightedArticleLast30Days = Article::withCount('comments')
            ->where('status', 'published')
            ->where(function ($q) use ($whereCategory) {
                $whereCategory($q);
            })
            ->where('created_at', '>=', now()->subDays(30)) // 30 ngày
            ->orderByDesc('comments_count') // Sắp xếp theo bình luận
            ->orderByDesc('views') // Sắp xếp theo views
            ->limit(5) // Giới hạn số lượng bài viết
            ->get();

        // Lưu các ID bài viết đã lấy vào danh sách loại trừ
        $excludedIds = array_merge($excludedIds, $highlightedArticleLast30Days->pluck('article_id')->toArray());


        // 4. Bài viết mới nhất (loại trừ tiếp)
        $latestArticles = Article::withCount('comments')
            ->where('status', 'published')
            ->where(function ($q) use ($whereCategory) {
                $whereCategory($q);
            })
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('created_at') // Sắp xếp theo thời gian tạo
            ->limit(2)
            ->get();

        // Lưu các ID bài viết đã lấy vào danh sách loại trừ
        $excludedIds = array_merge($excludedIds, $latestArticles->pluck('article_id')->toArray());

        // 4. 1 bài mới nhất còn lại (loại trừ tiếp)
        $singleLatestArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->where(function ($q) use ($whereCategory) {
                $whereCategory($q);
            })
            ->whereNotIn('article_id', $excludedIds)
            ->orderByDesc('created_at') // Sắp xếp theo thời gian tạo
            ->limit(1)
            ->get();

        // Lưu các ID bài viết đã lấy vào danh sách loại trừ
        $excludedIds = array_merge($excludedIds, $singleLatestArticle->pluck('article_id')->toArray());


        // 1. Tính toán phân trang các bài viết chưa hiển thị

        $perPage = 4; // Số bài viết mỗi trang
        $currentPage = request()->get('page', 1); // Trang hiện tại từ request

        // Lấy ra tất cả các bài viết chưa hiển thị (như trong các bước trước)
        $remainingArticles = Article::withCount('comments')
            ->where('status', 'published')
            ->where(function ($q) use ($whereCategory) {
                $whereCategory($q);
            })
            ->whereNotIn('article_id', $excludedIds) // Loại trừ các bài viết đã lấy
            ->orderByDesc('created_at') // Sắp xếp theo thời gian tạo hoặc tiêu chí bạn muốn
            ->get();

        // 2. Tính toán tổng số bài viết
        $totalArticles = $remainingArticles->count();

        // 3. Phân trang các bài viết
        $paginatedArticles = new \Illuminate\Pagination\LengthAwarePaginator(
            $remainingArticles->forPage($currentPage, $perPage), // Các bài viết phân trang
            $totalArticles, // Tổng số bài viết
            $perPage, // Số lượng bài viết mỗi trang
            $currentPage, // Trang hiện tại
            ['path' => request()->url()] // Giữ lại query params
        );

        // Trả về $paginatedArticles cho view hoặc xử lý tiếp








        // 5. Các dữ liệu khác (categories, tags, history, related)

        $categories = Category::withCount([
            'articles as articles_count' => fn($q) => $q->where('status', 'published'),
            'subArticles as sub_articles_count' => fn($q) => $q->where('status', 'published')
        ])
            ->where('is_active', 1)
            ->orderByRaw('articles_count + sub_articles_count DESC')
            ->take(6)
            ->get();

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
            $parentCat->total_articles_count = $parentCat->articles_count + $children->sum('articles_count');
            $parentCat->children = $children;
        }

        $tags = Tag::withCount('publishedArticles')
            ->has('publishedArticles')
            ->orderByDesc('published_articles_count')
            ->paginate(8);

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
            'relatedArticles' => $relatedArticles,
            'recentArticles' => $recentArticles,
            'tags' => $tags,
            'categories' => $categories,
            'category' => $category,
            'category2' => Category::all(),
            'highlightedArticle' => $highlightedArticle,
            'highlightedArticleByViews' => $highlightedArticleByViews,
            'latestArticles' => $latestArticles,
            'singleLatestArticle' => $singleLatestArticle,
            'paginatedArticles' => $paginatedArticles,
            'highlightedArticleLast30Days' => $highlightedArticleLast30Days
        ]);
    }
}
