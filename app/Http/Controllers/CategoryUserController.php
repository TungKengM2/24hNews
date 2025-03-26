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
        if ($childSlug) {
            // Đang truy cập danh mục con
            $category = Category::with(['parent', 'children'])
                ->where('slug', $childSlug)
                ->whereHas('parent', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->firstOrFail();
        } else {
            // Đang truy cập danh mục cha
            $category = Category::with(['parent', 'children'])
                ->where('slug', $slug)
                ->whereNull('parent_id')
                ->firstOrFail();
        }

        $categoryIds = $category->children->pluck('category_id')->push($category->category_id); // Lấy các category_id của danh mục hiện tại và các danh mục con

         // 3. Breaking news (3 bài mới nhất)
    $breakingNews = Article::where('status', 'published')
    ->whereHas('category', fn($q) => $q->where('is_active', 1)->whereIn('category_id', $categoryIds))
    ->orderByDesc('created_at')
    ->limit(3)
    ->get();

// 4. Hàm chọn bài nổi bật trong 7 ngày gần nhất
$selectTop = fn($exclude = []) => Article::withCount('comments')
    ->where('status', 'published')
    ->whereHas('category', fn($q) => $q->where('is_active', 1)->whereIn('category_id', $categoryIds))
    ->whereNotIn('article_id', collect($exclude)->merge($breakingNews->pluck('article_id')))
    ->where('created_at', '>=', Carbon::now()->subDays(7))
    ->orderByDesc('comments_count')
    ->orderByDesc('created_at')
    ->limit(1)
    ->first();

// 5. Highlighted article
$highlightedArticle = $selectTop();

// Fallback nếu không có bài nào trong 7 ngày
if (! $highlightedArticle) {
    $highlightedArticle = Article::withCount('comments')
        ->where('status', 'published')
        ->whereHas('category', fn($q) => $q->where('is_active', 1)->whereIn('category_id', $categoryIds))
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
        ->whereHas('category', fn($q) => $q->where('is_active', 1)->whereIn('category_id', $categoryIds))
        ->whereNotIn('article_id', array_filter([
            $highlightedId,
            ...$breakingNews->pluck('article_id')->toArray(),
        ]))
        ->orderByDesc('created_at')
        ->limit(1)
        ->first();
}

// 7. 3 bài khác (nebula nuggets)
$excludedIds = collect([
    optional($highlightedArticle)->article_id,
    optional($secondaryArticle)->article_id,
])->merge($breakingNews->pluck('article_id'))->filter()->unique();

$nebulaNuggets = Article::withCount('comments')
    ->where('status', 'published')
    ->whereHas('category', fn($q) => $q->where('is_active', 1)->whereIn('category_id', $categoryIds))
    ->whereNotIn('article_id', $excludedIds)
    ->orderByDesc('comments_count')
    ->orderByDesc('created_at')
    ->limit(3)
    ->get();

// 8. 5 bài xem nhiều nhất (most viewed)
$mostViewedArticles = Article::where('status', 'published')
    ->whereNotIn('article_id', $excludedIds)
    ->whereHas('category', fn($q) => $q->where('is_active', 1)->whereIn('category_id', $categoryIds))
    ->orderByDesc('views')
    ->take(6)
    ->get();

    $topMainArticle = $mostViewedArticles->take(2);    // 2 bài đầu
$topSideArticles = $mostViewedArticles->slice(2);





        // Lấy các bài viết mới trong danh mục (theo category_id)
        $articlesNews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->get();

        // Lấy bài viết trong danh mục
        $articles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->paginate(10);

        // Lấy bài viết nhiều lượt xem nhất
        $articlesViews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->distinct()
            ->paginate(4);

        // Lấy bài viết nổi bật
        $featuredArticle = Article::with('category')
            ->where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->limit(4)
            ->first();

        $userId = auth()->check() ? auth()->id() : null;
        $userIp = request()->ip();

        $viewedArticleIds = ArticleView::where(function ($query) use ($userId, $userIp) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->whereNull('user_id')->where('anonymous', $userIp);
            }
        })
            ->orderByDesc('viewed_at') // ← chính xác ở đây
            ->pluck('article_id');


        // Lấy bài viết đã xem, thuộc danh mục đang truy cập (bao gồm cả con nếu có)
        $recentArticles = Article::where('status', 'published')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('is_active', 1)
                    ->where('category_id', $category->category_id);
            })
            ->where('article_id', '!=', optional($highlightedArticle)->article_id)
            ->whereIn('article_id', function ($query) use ($userId, $userIp) {
                $query->select('article_id')
                    ->from('article_views')
                    ->when($userId, fn($q) => $q->where('user_id', $userId))
                    ->when(!$userId, fn($q) => $q->whereNull('user_id')->where('anonymous', $userIp))
                    ->orderByDesc('viewed_at');
            })
            ->limit(4)
            ->get();


<<<<<<< HEAD

        // Lấy bài viết liên quan (không trùng với recentArticles và bài nổi bật)
        $relatedArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereNotIn('article_id', $recentArticles->pluck('article_id')->toArray())
            ->where('article_id', '!=', optional($featuredArticle)->article_id)
            ->orderBy('views', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->limit(4)
            ->get();

        // Lấy các tag có bài viết đã xuất bản
        $tags = Tag::withCount('publishedArticles')
            ->has('publishedArticles')
            ->orderByDesc('published_articles_count')
            ->paginate(8);

        // Lấy các danh mục (cho sidebar nếu cần)
        $categories = Category::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])
            ->where('is_active', 1)
            ->orderByDesc('articles_count')
            ->take(6)
            ->get();

        // Lấy danh mục cha (parent categories) cho menu, kiểu phân trang (nếu muốn)
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', 1)
            ->withCount(['articles' => function ($query) {
                // Chỉ đếm bài viết có is_active = 1
                $query->where('is_active', 1);
            }])
            ->orderByDesc('articles_count') // Sắp xếp theo số lượng bài viết trực tiếp của cha giảm dần
            ->paginate(10);

        // Lấy ID của các danh mục cha trên trang hiện tại dựa trên category_id
        $parentIds = $parentCategories->pluck('category_id')->toArray();

        // Lấy danh mục con của các danh mục cha vừa chọn với điều kiện is_active = 1
        $childCategories = Category::whereIn('parent_id', $parentIds)
            ->where('is_active', 1)
            ->withCount(['articles' => function ($query) {
                $query->where('is_active', 1);
            }])
            ->get()
            ->groupBy('parent_id');

        // Gắn danh mục con vào từng danh mục cha, tính tổng bài viết (cha + con)
        foreach ($parentCategories as $parentCat) {
            // Nếu không có danh mục con nào, ta lấy một collection rỗng
            $children = $childCategories[$parentCat->category_id] ?? collect();

            // Tính tổng số bài viết của tất cả các danh mục con
            $childArticlesCount = $children->sum('articles_count');

            // Cộng số bài viết của danh mục cha và các danh mục con
            $parentCat->total_articles_count = $parentCat->articles_count + $childArticlesCount;

            // Gán danh sách danh mục con cho danh mục cha
            $parentCat->children = $children;
        }
=======
        $categories = Category::where('is_active', 1)->limit(7)->get();
        $category2 = Category::where('is_active', 1)->get(); // Lấy danh sách danh mục
        
>>>>>>> dadf66f2 (có trang tag)

        // Trả về view với các biến cần thiết
        return view('website.categories.categories', [
            'parentCategories' => $parentCategories,
            'relatedArticles'  => $relatedArticles,
            'recentArticles'   => $recentArticles,
            'tags'             => $tags,
            'categories'       => $categories,
            'articlesNews'     => $articlesNews,
            'category'         => $category,
            'category2'        => Category::all(), // Ví dụ: lấy tất cả các danh mục
            'articles'         => $articles,
            'articlesViews'    => $articlesViews,
            'featuredArticle'  => $featuredArticle,
            'breakingNews'    => $breakingNews,
            'highlightedArticle' => $highlightedArticle,
            'secondaryArticle' => $secondaryArticle,
            'nebulaNuggets' => $nebulaNuggets,
            'topSideArticles' => $topSideArticles,
            'topMainArticle' => $topMainArticle
        ]);
    }
}
