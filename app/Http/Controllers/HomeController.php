<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\ArticleLike;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //tin noi bat
        $featuredArticles = Article::select('articles.*')
            ->join('users', 'users.user_id', '=', 'articles.author_id')
            ->where('articles.status', 'published')
            ->where(function ($query) {
                $query->where('articles.contains_sensitive_content', 0)
                    ->orWhereNull('articles.contains_sensitive_content');
            })
            ->where('articles.created_at', '>=', now()->subDays(7))
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->where(function ($q) {
                $q->where('users.is_promoted', 1)
                    ->orWhere('users.violation_count', '<', 3);
            })
            ->whereNull('users.banned_until')
            ->whereNotNull('users.email_verified_at')
            ->orderByDesc('articles.views')
            ->take(7)
            ->get();

        //4 tag có nhiều bài viết nhất 
        $topTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(4)
            ->get();



        // top 3 bài viết nhiều lượt xem
        $D1Articles = Article::where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(30)) // trong 30 ngày gần đây
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->orderByDesc('views') // sắp xếp theo lượt xem
            ->take(3)
            ->get();



        // top 4 bài viết nhiều Bluan nhất 30 ngày trở lại   
        $trendingPosts = Article::withCount('comments')
            ->where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(30)) // Chỉ lấy bài viết trong 30 ngày gần đây
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->orderByDesc('comments_count') // Sắp xếp theo số lượng bình luận
            ->limit(4)
            ->get();


        // Lấy danh sách bài viết mới nhất
        $articles = Article::where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })->latest()->get();

        $journalists = User::where('role_id', 3)
            ->get(); // Lấy nhà báo có ID = 3


        $topAuthors = $this->getTopAuthorsOfWeek();
        // $topAuthors = 0;
        // dd($topAuthors);

        $sportsArticles = Article::whereHas('category', function ($query) {
            $query->where('name', 'Thể Thao'); // Hoặc sử dụng category_id cụ thể
        })->inRandomOrder()->distinct()
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })->get();

        $categories = Category::where('is_active', 1)->limit(5)->get();
        $newsData = [];

        foreach ($categories as $category) {
            $article = Article::where([
                ['category_id', $category->category_id],
                ['status', 'published'],
                ['created_at', '>=', Carbon::now()->subDays(30)], // trong 30 ngày gần đây
            ])
                ->whereHas('category', fn($q) => $q->where('is_active', 1))
                ->latest('created_at') // tương đương orderByDesc
                ->first();

            if ($article) {
                $newsData[] = compact('category', 'article'); // gọn hơn
            }
        }

        $category2 = Category::withCount(['articles' => function ($query) {
            $query->where('status', 'published'); // Điều kiện bài viết có trạng thái 'published'
        }])->where('is_active', 1)->get();



        //TungKeng làm hiển thị bài viết của author mà user đã fl
        $user = auth()->user();

        if (!$user) {
            return view('welcome', [
                'topTags' => $topTags ?? null,
                'categories' => $categories ?? null,
                'category2' => $category2 ?? null,
                'sportsArticles' => $sportsArticles ?? null,
                'newsData' => $newsData ?? null,
                'journalists' => $journalists ?? null,
                'trendingPosts' => $trendingPosts ?? null,
                'featuredArticles' => $featuredArticles ?? null,
                'articles' => $articles ?? null,
                'D1Articles' => $D1Articles ?? null,
                'articlesfollow' => collect(),
                'followMessage' => 'Bạn chưa đăng ký/đăng nhập để theo dõi tác giả.',
                'topAuthors' => $topAuthors ?? collect(),
            ]);
        }

        $followMessage = $user ? '' : 'Bạn chưa đăng ký/đăng nhập để theo dõi tác giả.';

        // Lấy danh sách ID của những tác giả mà user đang follow
        $followingIds = $user->following()->pluck('following_id');

        // Lấy bài viết của những tác giả đó
        $articlesfollow = Article::whereIn('author_id',  $followingIds)
            ->where('status', 'published')
            ->whereDate('created_at', Carbon::today())
            ->latest() // Sắp xếp theo mới nhất
            ->get();
        
        
           

        // Truyền dữ liệu bài viết tới view
        
        return view('welcome', compact(
            'categories',
            'category2',
            'sportsArticles',
            'newsData',
            'journalists',
            'trendingPosts',
            'featuredArticles',
            'articles',
            'D1Articles',
            'articlesfollow',
            'followMessage',
            'topAuthors',
            'topTags'
        ));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $results = [];

        if ($keyword) {
            // Tìm kiếm chính xác theo từng ký tự trong tiêu đề
            $articles = Article::where('status', 'published')
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%{$keyword}%");
                })
                ->orderBy('views', 'desc')
                ->get();

            foreach ($articles as $article) {
                // Tính độ phù hợp dựa trên vị trí xuất hiện của từ khóa trong tiêu đề
                $relevance = 0;
                $title = mb_strtolower($article->title);
                $keyword = mb_strtolower($keyword);

                // Tăng điểm nếu từ khóa xuất hiện ở đầu tiêu đề
                if (mb_strpos($title, $keyword) === 0) {
                    $relevance += 3;
                }
                // Tăng điểm nếu từ khóa xuất hiện trong tiêu đề
                elseif (mb_strpos($title, $keyword) !== false) {
                    $relevance += 2;
                }

                // Chỉ thêm kết quả có độ phù hợp > 0
                if ($relevance > 0) {
                    $results[] = [
                        'title' => $article->title,
                        'url' => Auth::check() ? route('articles.article', $article->slug) : url('/login-user'),
                        'relevance' => $relevance
                    ];
                }
            }

            // Sắp xếp kết quả theo độ phù hợp
            usort($results, function ($a, $b) {
                return $b['relevance'] - $a['relevance'];
            });

            // Chỉ trả về 10 kết quả phù hợp nhất
            $results = array_slice($results, 0, 10);
        }

        return response()->json(['results' => $results]);
    }


    private function getTopAuthorsOfWeek()
    {
        // Lấy tất cả tác giả có ít nhất 3 bài viết đã xuất bản
        $authors = User::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])
        ->having('articles_count', '>=', 3)
        ->get();

        // Tính điểm trung bình cho mỗi tác giả
        $ratedAuthors = $authors->map(function ($author) {
            // Lấy bài viết đã xuất bản của tác giả
            $articles = Article::where('author_id', $author->user_id)
                ->where('status', 'published')
                ->get();
            
            // Tính tổng điểm đánh giá
            $totalStars = $articles->sum(function ($article) {
                return $article->rating_star;
            });
            
            // Tính điểm trung bình
            $averageRating = number_format($totalStars / max($articles->count(), 1), 1);
            
            return [
                'author' => $author,
                'rating' => $averageRating,
                'articles_count' => $articles->count(),
                'specializes_in' => $this->getAuthorSpecialization($author)
            ];
        })
        ->sortByDesc('rating')
        ->take(5)
        ->values();

        return $ratedAuthors;
    }


    private function getAuthorSpecialization($author)
    {
        // Lấy danh mục mà tác giả viết nhiều bài nhất
        $topCategory = Article::where('author_id', $author->user_id)
            ->where('status', 'published')
            ->join('categories', 'articles.category_id', '=', 'categories.category_id')
            ->select('categories.name')
            ->groupBy('categories.name')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        return $topCategory ? $topCategory->name : 'Chưa xác định';
    }
}
