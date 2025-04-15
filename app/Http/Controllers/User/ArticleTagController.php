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
        // Lấy thông tin tag
        $tag = Tag::where('tag_id', $tag)->firstOrFail();

        // Lấy bài viết mới nhất có tag này, trong 7 ngày gần đây
        $articlesNews = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(7)) // Chỉ lấy bài trong 7 ngày gần đây
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();



        // Lấy bài viết nhiều lượt xem nhất có tag này trong 7 ngày gần đây
        $articlesViews = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(7)) // Lọc theo 7 ngày gần đây
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        // Lấy danh sách bài viết có tag này
        $tags = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $articleIds = $articlesViews->pluck('article_id'); // Lấy danh sách ID bài viết đã hiển thị

        // . Lấy các bài viết khác cùng tag, loại trừ bài đã hiển thị
        $otherArticles = Article::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.tag_id', $tag->tag_id);
        })
            ->where('status', 'published')
            ->whereNotIn('article_id', $articleIds)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(8); 


        // Lấy tất cả tags
        $tags = Tag::withCount('publishedArticles')
        ->has('publishedArticles') // chỉ lấy tag có bài viết đã xuất bản
        ->orderByDesc('published_articles_count')
        ->paginate(8);

        $categories = Category::where('is_active', 1)->limit(7)->get();
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


        return view('website.articles.tag', compact(
            'categories',
            'category2',
            'parentCategories',
            'tag',
            'tags',
            'articlesNews',
            'articlesViews',
            'otherArticles',
            'tags'
        ));
    }
}
