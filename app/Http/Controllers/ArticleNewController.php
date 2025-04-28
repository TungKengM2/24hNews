<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
class ArticleNewController extends Controller
{
    public function index()

    {

        $articles = Article::where('status', 'published')
        ->whereHas('category', fn($q) => $q->where('is_active', 1))
        ->orderBy('created_at', 'desc')
        ->paginate(16); // mỗi trang 15 bài
    

  


        // 1) Lấy 3 category hoạt động nhiều bài published nhất
        $topCategories = Category::where('is_active', 1)
            ->withCount(['articles' => function ($q) {
                $q->where('status', 'published');
            }])
            ->orderByDesc('articles_count')
            ->take(3)
            ->get();

        // 2) Với mỗi category, chỉ lấy 3 bài published mới nhất
        $topCategoriesWithArticles = $topCategories->map(function ($category) {
            $articles = $category->articles()
                ->where('status', 'published')
                ->latest()      // thường là orderBy('created_at','desc')
                ->take(3)
                ->get();

            return [
                'category'     => $category,
                'main_article' => $articles->first(),     // bài đầu làm nổi bật
                'sub_articles' => $articles->slice(1),    // 2 bài còn lại
            ];
        });


        // 1. Bài viết nổi bật (NewsArticle)
        $NewsArticle = Article::withCount('comments')
            ->where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->orderByDesc('created_at')
            ->first();

        // 4. Categories data
        $categories = Category::withCount([
            'articles as articles_count' => fn($q) => $q->where('status', 'published'),
            'subArticles as sub_articles_count' => fn($q) => $q->where('status', 'published')
        ])
            ->where('is_active', 1)
            ->orderByRaw('articles_count + sub_articles_count DESC')
            ->take(6)
            ->get();

        // 5. phân trang parentCategories
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

        return view('website.articles.newarticle', [
            'topCategoriesWithArticles' => $topCategoriesWithArticles,
            'articles' => $articles,
            'parentCategories' => $parentCategories,
            'categories' => $categories,
            'NewsArticle' => $NewsArticle,
            'category2' => Category::all()
        ]);
    }

    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 8; // số bài viết mỗi lần load
        $articles = Article::with('category')
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // Xử lý content trước khi trả về JSON
        $articles->transform(function ($article) {
            $article->content = Str::limit(strip_tags(html_entity_decode($article->content)), 100);
            return $article;
        });

        return response()->json($articles);
    }
}
