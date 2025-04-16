<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;

class CategoryUserController extends Controller
{
    public function index($slug)
    {
        // Lấy danh mục hiện tại theo slug và load quan hệ parent, children (nếu đã định nghĩa quan hệ trong model)
        $category = Category::with('parent', 'children')
            ->where('slug', $slug)
            ->firstOrFail();

        // Vì bảng categories sử dụng category_id làm khóa chính nên thay $category->id bằng $category->category_id

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

        // Lấy bài viết phụ không trùng với bài nổi bật
        $recentArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->where('article_id', '!=', optional($featuredArticle)->article_id)
            ->orderBy('views', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->limit(4)
            ->get();

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
            'featuredArticle'  => $featuredArticle
        ]);
    }
}
