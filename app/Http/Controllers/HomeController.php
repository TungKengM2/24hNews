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
        // Truy vấn bài viết trong 7 ngày gần nhất
        $recentArticles = Article::select('articles.*')
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
            ->orderByDesc('articles.views')
            ->take(7)
            ->get();

        // Nếu chưa đủ 7 bài, lấy thêm các bài cũ hơn
        if ($recentArticles->count() < 7) {
            $additionalArticles = Article::select('articles.*')
                ->join('users', 'users.user_id', '=', 'articles.author_id')
                ->where('articles.status', 'published')
                ->where(function ($query) {
                    $query->where('articles.contains_sensitive_content', 0)
                        ->orWhereNull('articles.contains_sensitive_content');
                })
                ->where('articles.created_at', '<', now()->subDays(7))
                ->whereHas('category', fn($q) => $q->where('is_active', 1))
                ->where(function ($q) {
                    $q->where('users.is_promoted', 1)
                        ->orWhere('users.violation_count', '<', 3);
                })
                ->whereNull('users.banned_until')
                ->whereNotNull('users.email_verified_at')
                ->orderByDesc('articles.views')
                ->take(7 - $recentArticles->count())
                ->get();

            $featuredArticles = $recentArticles->concat($additionalArticles);
        } else {
            $featuredArticles = $recentArticles;
        }





        // top 3 bài viết nhiều lượt xem
        $D1Articles = Article::where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(30)) // trong 30 ngày gần đây
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->orderByDesc('views') // sắp xếp theo lượt xem
            ->take(3)
            ->get();

        //bai viet moi nhâts
        $NewsArticle = Article::withCount('comments') // Đếm số bình luận
            ->where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->orderByDesc('created_at')
            ->first();
        // lấy bài viết mới nhất của 6dmuc
        $latestArticlesPerCategory = Article::with('category')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->orderByDesc('created_at')
            ->get()
            ->unique('category_id') // loại trùng theo danh mục
            ->take(6);

        //top blan trong 30ngay
        $trendingPosts = Article::withCount(['comments as recent_comments_count' => function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30)); // Chỉ tính bình luận trong 30 ngày qua
        }])
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải hoạt động
            })
            ->orderByDesc('recent_comments_count') // Sắp xếp theo số bình luận trong 30 ngày qua
            ->limit(4)
            ->get();

        // Gom ID các bài đã có để tránh trùng
        $excludeIds = collect()
            ->merge($D1Articles->pluck('id'))
            ->push(optional($NewsArticle)->id)
            ->merge($latestArticlesPerCategory->pluck('id'))
            ->merge($trendingPosts->pluck('id'))
            ->filter()
            ->unique()
            ->toArray();

        // Random 2 bài viết khác
        $randomArticles = Article::where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('is_active', 1))
            ->whereNotIn('id', $excludeIds)
            ->inRandomOrder()
            ->take(2)
            ->get();

        $weeklyTrendingArticles = Article::with(['category'])
            ->where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(7)) // Lọc bài viết trong tuần qua
            ->whereHas('category', fn($q) => $q->where('is_active', 1)) // Lọc bài viết theo danh mục đang hoạt động
            ->orderByDesc('views') // Sắp xếp theo cột views (số lượt xem)
            ->take(5) // Lấy tối đa 5 bài viết
            ->get();

        // Lấy 3 danh mục có nhiều bài viết nhất
        $topCategories = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(3)
            ->get();

        $topCategoriesWithArticles = $topCategories->map(function ($category) {
            $articles = $category->articles()
                ->latest()
                ->take(3)
                ->get();

            return [
                'category' => $category,
                'main_article' => $articles->first(),
                'sub_articles' => $articles->slice(1),
            ];
        });






        //4 tag có nhiều bài viết nhất
        $topTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(4)
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




        //TungKeng làm hiển thị bài viết của author mà user đã fl
        $user = auth()->user();

        if (!$user) {
            return view('welcome', [
                'topCategoriesWithArticles' => $topCategoriesWithArticles ?? null,
                'topCategories' => $topCategories ?? null,
                'topTags' => $topTags ?? null,
                'weeklyTrendingArticles' => $weeklyTrendingArticles ?? null,
                'randomArticles' => $randomArticles ?? null,
                'latestArticlesPerCategory' => $latestArticlesPerCategory ?? null,
                'categories' => $categories ?? null,
                'category2' => $category2 ?? null,
                'parentCategories' => $parentCategories ?? null,
                'sportsArticles' => $sportsArticles ?? null,
                'newsData' => $newsData ?? null,
                'NewsArticle' => $NewsArticle ?? null,
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
            'parentCategories',
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
            'topTags',
            'NewsArticle',
            'latestArticlesPerCategory',
            'randomArticles',
            'weeklyTrendingArticles',
            'topCategoriesWithArticles',
            'topCategories' 
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

    /**
     * Trả về gợi ý tên bài viết khi nhập từ khóa với độ chính xác cao
     */
    public function suggestions(Request $request)
    {
        $keyword = $request->input('keyword');
        $suggestions = [];

        if ($keyword && strlen($keyword) >= 2) {
            // Tìm kiếm bài viết có tiêu đề chứa từ khóa
            $articles = Article::where('status', 'published')
                ->where(function($query) use ($keyword) {
                    // Tìm kiếm chính xác hơn với nhiều điều kiện
                    $query->where('title', 'LIKE', "{$keyword}%") // Bắt đầu bằng từ khóa (ưu tiên cao nhất)
                          ->orWhere('title', 'LIKE', "% {$keyword}%") // Từ khóa xuất hiện sau khoảng trắng
                          ->orWhere('title', 'LIKE', "%{$keyword}%"); // Chứa từ khóa ở bất kỳ đâu (ưu tiên thấp nhất)
                })
                ->orderBy('views', 'desc') // Ưu tiên bài viết có nhiều lượt xem
                ->limit(15) // Lấy 15 bài để xử lý và lọc ra 5 bài phù hợp nhất
                ->get();

            // Mảng để lưu kết quả có xếp hạng
            $rankedSuggestions = [];

            foreach ($articles as $article) {
                $title = $article->title;
                $lowerTitle = mb_strtolower($title);
                $lowerKeyword = mb_strtolower($keyword);

                // Tính điểm phù hợp
                $relevance = 0;

                // Nếu tiêu đề bắt đầu bằng từ khóa (ưu tiên cao nhất)
                if (mb_strpos($lowerTitle, $lowerKeyword) === 0) {
                    $relevance += 10;
                }
                // Nếu từ khóa xuất hiện sau khoảng trắng (ưu tiên trung bình)
                elseif (mb_strpos($lowerTitle, ' ' . $lowerKeyword) !== false) {
                    $relevance += 5;
                }
                // Nếu từ khóa xuất hiện ở bất kỳ đâu (ưu tiên thấp)
                elseif (mb_strpos($lowerTitle, $lowerKeyword) !== false) {
                    $relevance += 2;
                }

                // Cộng thêm điểm dựa trên lượt xem (tối đa 3 điểm)
                $viewPoints = min(3, $article->views / 1000);
                $relevance += $viewPoints;

                // Cộng thêm điểm nếu tiêu đề ngắn gọn (dễ đọc hơn)
                if (mb_strlen($title) < 50) {
                    $relevance += 1;
                }

                // Thêm vào mảng kết quả có xếp hạng
                $rankedSuggestions[] = [
                    'title' => $title,
                    'relevance' => $relevance
                ];
            }

            // Sắp xếp theo độ phù hợp giảm dần
            usort($rankedSuggestions, function($a, $b) {
                return $b['relevance'] - $a['relevance'];
            });

            // Lấy 5 kết quả phù hợp nhất và loại bỏ trùng lặp
            $uniqueTitles = [];
            foreach ($rankedSuggestions as $suggestion) {
                $title = $suggestion['title'];
                if (!in_array($title, $uniqueTitles)) {
                    $uniqueTitles[] = $title;
                    if (count($uniqueTitles) >= 5) {
                        break;
                    }
                }
            }

            $suggestions = $uniqueTitles;
        }

        return response()->json(['suggestions' => $suggestions]);
    }

    /**
     * Trả về gợi ý danh mục khi nhập từ khóa
     */
    public function categorySuggestions(Request $request)
    {
        $keyword = $request->input('keyword');
        $suggestions = [];

        if ($keyword && strlen($keyword) >= 2) {
            // Tìm kiếm danh mục có tên chứa từ khóa
            $categories = Category::where('is_active', 1)
                ->where(function($query) use ($keyword) {
                    // Tìm kiếm chính xác hơn với nhiều điều kiện
                    $query->where('name', 'LIKE', "{$keyword}%") // Bắt đầu bằng từ khóa (ưu tiên cao nhất)
                          ->orWhere('name', 'LIKE', "% {$keyword}%") // Từ khóa xuất hiện sau khoảng trắng
                          ->orWhere('name', 'LIKE', "%{$keyword}%"); // Chứa từ khóa ở bất kỳ đâu (ưu tiên thấp nhất)
                })
                ->withCount('articles') // Đếm số bài viết trong danh mục
                ->orderByDesc('articles_count') // Ưu tiên danh mục có nhiều bài viết
                ->limit(15) // Lấy 15 danh mục để xử lý và lọc ra 5 danh mục phù hợp nhất
                ->get();

            // Mảng để lưu kết quả có xếp hạng
            $rankedSuggestions = [];

            foreach ($categories as $category) {
                $name = $category->name;
                $lowerName = mb_strtolower($name);
                $lowerKeyword = mb_strtolower($keyword);

                // Tính điểm phù hợp
                $relevance = 0;

                // Nếu tên danh mục bắt đầu bằng từ khóa (ưu tiên cao nhất)
                if (mb_strpos($lowerName, $lowerKeyword) === 0) {
                    $relevance += 10;
                }
                // Nếu từ khóa xuất hiện sau khoảng trắng (ưu tiên trung bình)
                elseif (mb_strpos($lowerName, ' ' . $lowerKeyword) !== false) {
                    $relevance += 5;
                }
                // Nếu từ khóa xuất hiện ở bất kỳ đâu (ưu tiên thấp)
                elseif (mb_strpos($lowerName, $lowerKeyword) !== false) {
                    $relevance += 2;
                }

                // Cộng thêm điểm dựa trên số lượng bài viết (tối đa 3 điểm)
                $articlesPoints = min(3, $category->articles_count / 10);
                $relevance += $articlesPoints;

                // Cộng thêm điểm nếu tên danh mục ngắn gọn (dễ đọc hơn)
                if (mb_strlen($name) < 20) {
                    $relevance += 1;
                }

                // Thêm vào mảng kết quả có xếp hạng
                $rankedSuggestions[] = [
                    'name' => $name,
                    'slug' => $category->slug,
                    'relevance' => $relevance,
                    'type' => 'category' // Đánh dấu đây là danh mục
                ];
            }

            // Sắp xếp theo độ phù hợp giảm dần
            usort($rankedSuggestions, function($a, $b) {
                return $b['relevance'] - $a['relevance'];
            });

            // Lấy 5 kết quả phù hợp nhất và loại bỏ trùng lặp
            $uniqueCategories = [];
            foreach ($rankedSuggestions as $suggestion) {
                $name = $suggestion['name'];
                if (!in_array($name, $uniqueCategories)) {
                    $uniqueCategories[] = $suggestion;
                    if (count($uniqueCategories) >= 5) {
                        break;
                    }
                }
            }

            $suggestions = $uniqueCategories;
        }

        return response()->json(['suggestions' => $suggestions]);
    }

    /**
     * Trả về gợi ý thẻ tag khi nhập từ khóa
     */
    public function tagSuggestions(Request $request)
    {
        $keyword = $request->input('keyword');
        $suggestions = [];

        if ($keyword && strlen($keyword) >= 2) {
            // Tìm kiếm tag có tên chứa từ khóa
            $tags = Tag::where(function($query) use ($keyword) {
                    // Tìm kiếm chính xác hơn với nhiều điều kiện
                    $query->where('name', 'LIKE', "{$keyword}%") // Bắt đầu bằng từ khóa (ưu tiên cao nhất)
                          ->orWhere('name', 'LIKE', "% {$keyword}%") // Từ khóa xuất hiện sau khoảng trắng
                          ->orWhere('name', 'LIKE', "%{$keyword}%"); // Chứa từ khóa ở bất kỳ đâu (ưu tiên thấp nhất)
                })
                ->withCount('publishedArticles') // Đếm số bài viết đã xuất bản có tag này
                ->has('publishedArticles') // Chỉ lấy tag có bài viết đã xuất bản
                ->orderByDesc('published_articles_count') // Ưu tiên tag có nhiều bài viết
                ->limit(15) // Lấy 15 tag để xử lý và lọc ra 5 tag phù hợp nhất
                ->get();

            // Mảng để lưu kết quả có xếp hạng
            $rankedSuggestions = [];

            foreach ($tags as $tag) {
                $name = $tag->name;
                $lowerName = mb_strtolower($name);
                $lowerKeyword = mb_strtolower($keyword);

                // Tính điểm phù hợp
                $relevance = 0;

                // Nếu tên tag bắt đầu bằng từ khóa (ưu tiên cao nhất)
                if (mb_strpos($lowerName, $lowerKeyword) === 0) {
                    $relevance += 10;
                }
                // Nếu từ khóa xuất hiện sau khoảng trắng (ưu tiên trung bình)
                elseif (mb_strpos($lowerName, ' ' . $lowerKeyword) !== false) {
                    $relevance += 5;
                }
                // Nếu từ khóa xuất hiện ở bất kỳ đâu (ưu tiên thấp)
                elseif (mb_strpos($lowerName, $lowerKeyword) !== false) {
                    $relevance += 2;
                }

                // Cộng thêm điểm dựa trên số lượng bài viết (tối đa 3 điểm)
                $articlesPoints = min(3, $tag->published_articles_count / 5);
                $relevance += $articlesPoints;

                // Cộng thêm điểm nếu tên tag ngắn gọn (dễ đọc hơn)
                if (mb_strlen($name) < 15) {
                    $relevance += 1;
                }

                // Thêm vào mảng kết quả có xếp hạng
                $rankedSuggestions[] = [
                    'name' => $name,
                    'tag_id' => $tag->tag_id,
                    'relevance' => $relevance,
                    'type' => 'tag' // Đánh dấu đây là tag
                ];
            }

            // Sắp xếp theo độ phù hợp giảm dần
            usort($rankedSuggestions, function($a, $b) {
                return $b['relevance'] - $a['relevance'];
            });

            // Lấy 5 kết quả phù hợp nhất và loại bỏ trùng lặp
            $uniqueTags = [];
            foreach ($rankedSuggestions as $suggestion) {
                $name = $suggestion['name'];
                if (!in_array($name, $uniqueTags)) {
                    $uniqueTags[] = $suggestion;
                    if (count($uniqueTags) >= 5) {
                        break;
                    }
                }
            }

            $suggestions = $uniqueTags;
        }

        return response()->json(['suggestions' => $suggestions]);
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

            // Lấy thông tin chuyên môn của tác giả
            $topCategory = Article::where('author_id', $author->user_id)
                ->where('status', 'published')
                ->join('categories', 'articles.category_id', '=', 'categories.category_id')
                ->select('categories.name', 'categories.slug', 'categories.category_id')
                ->groupBy('categories.name', 'categories.slug', 'categories.category_id')
                ->orderByRaw('COUNT(*) DESC')
                ->first();

            return [
                'author' => $author,
                'rating' => $averageRating,
                'articles_count' => $articles->count(),
                'specializes_in' => $topCategory ? $topCategory->name : 'Chưa xác định',
                'specializes_slug' => $topCategory ? $topCategory->slug : null,
                'specializes_id' => $topCategory ? $topCategory->category_id : null
            ];
        })
        ->sortByDesc('rating')
        ->take(3)
        ->values();

        return $ratedAuthors;
    }


}
