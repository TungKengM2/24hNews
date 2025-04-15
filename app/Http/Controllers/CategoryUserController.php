<?php

namespace App\Http\Controllers; // Đảm bảo namespace đúng

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;

class CategoryUserController extends Controller
{
    public function index($categoryid)
    {
        $category = Category::where('slug', $categoryid)->firstOrFail();


        $articlesNews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc') // Sắp xếp theo bài viết mới nhất
            ->limit(4)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->get();


        // Lấy bài viết thuộc danh mục
        $articles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->paginate(10);

        // Lấy bài viết nhiều lượt xem nhất
        $articlesViews = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->distinct() // Loại bỏ bản ghi trùng lặp
            ->paginate(4);



        $featuredArticle = Article::with('category') // Load cả danh mục
            ->where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->limit(4)
            ->first();


        // Lấy 5 bài viết phụ (không trùng bài nổi bật)
        $recentArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->where('article_id', '!=', optional($featuredArticle)->article_id) // Đổi id thành article_id
            ->orderBy('views', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->limit(4)
            ->get();

        // Lấy các bài viết liên quan (không trùng bài trong $recentArticles)
        $relatedArticles = Article::where('category_id', $category->category_id)
            ->where('status', 'published')
            ->whereNotIn('article_id', $recentArticles->pluck('article_id')->toArray()) // So sánh với các ID bài viết trong $recentArticles
            ->where('article_id', '!=', optional($featuredArticle)->article_id) // Đảm bảo không trùng với bài viết nổi bật
            ->orderBy('views', 'desc')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->limit(4)
            ->get();


        // Lấy tất cả tags
        $tags = Tag::withCount('publishedArticles')
        ->has('publishedArticles') // chỉ lấy tag có bài viết đã xuất bản
        ->orderByDesc('published_articles_count')
        ->paginate(8);

        $categories = Category::withCount(['articles' => function ($query) {
            $query->where('status', 'published'); // Đếm bài viết có trạng thái 'published'
        }])
        ->where('is_active', 1)
        ->orderByDesc('articles_count')  // Sắp xếp theo số lượng bài viết giảm dần
        ->take(6)  // Giới hạn 6 danh mục
        ->get();
        
        

            $category2 = Category::withCount(['articles' => function ($query) {
                $query->where('status', 'published'); // Điều kiện bài viết có trạng thái 'published'
            }])->where('is_active', 1)->get();
             
        
        // Lấy tất cả danh mục cha (parent_id = null) với điều kiện is_active = 1
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', 1)
            ->withCount(['articles' => function ($query) {
                // Chỉ đếm bài viết có is_active = 1
                $query->where('is_active', 1);
            }])
            ->orderBy('articles_count', 'desc') // Sắp xếp theo số lượng bài viết trực tiếp của cha giảm dần
            ->paginate(10);

        // Lấy ID của các danh mục cha trên trang hiện tại
        $parentIds = $parentCategories->pluck('category_id')->toArray();

        // Lấy danh mục con của các danh mục cha vừa chọn với điều kiện is_active = 1
        $childCategories = Category::whereIn('parent_id', $parentIds)
            ->where('is_active', 1)
            ->withCount(['articles' => function ($query) {
                $query->where('is_active', 1);
            }])
            ->get()
            ->groupBy('parent_id');

        // Gắn danh mục con vào từng danh mục cha và tính tổng số bài viết (cha + con)
        foreach ($parentCategories as $category) {
            // Lấy danh sách danh mục con của danh mục cha hiện tại
            $children = $childCategories[$category->category_id] ?? collect();

            // Tính tổng số bài viết ở danh mục con
            $childArticlesCount = $children->sum('articles_count');

            // Tạo thuộc tính mới total_articles_count = bài viết của cha + bài viết của con
            $category->total_articles_count = $category->articles_count + $childArticlesCount;

            // Gán danh mục con vào thuộc tính children
            $category->children = $children;
        }
            



        return view('website.categories.categories', compact('parentCategories','relatedArticles', 'recentArticles', 'tags', 'categories', 'articlesNews', 'category2', 'articles', 'articlesViews', 'category', 'featuredArticle'));
    }
}
