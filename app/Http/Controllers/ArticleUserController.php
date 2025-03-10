<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\ArticleView;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleUserController extends Controller
{
    public function show($article_id)
    {
        $article = Article::where('article_id', $article_id)->first();

        if (! $article) {
            abort(404, 'Bài viết không tồn tại!');
        }

        $userId = auth()->id();
        $userIp = request()->ip();

        // Kiểm tra xem user đã like bài viết chưa
        $isLiked = false;
        if ($userId) {
            $isLiked = ArticleLike::where('article_id',
                $article->article_id)
                ->where('user_id', $userId)
                ->exists();
        }

        // Lấy số lượt like
        $likeCount = ArticleLike::where('article_id', $article->article_id)
            ->count();

        // Kiểm tra xem user đã xem bài viết chưa
        $hasViewed = ArticleView::where('article_id', $article->article_id)
            ->where(function ($query) use ($userId, $userIp) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->whereNull('user_id')
                        ->where('anonymous', $userIp);
                }
            })
            ->exists();

        // Nếu chưa xem, thêm vào database & tăng lượt xem
        if (! $hasViewed) {
            ArticleView::create([
                'article_id' => $article->article_id,
                'user_id' => $userId,
                'ip_address' => $userIp,
                'viewed_at' => now(),
            ]);

            $article->increment('views');
        }

        // Lấy bài viết liên quan
        $relatedArticles = Article::where('category_id',
            $article->category_id)
            ->where('article_id', '!=', $article->article_id)
            ->limit(5)
            ->get();

        // Lấy danh sách bình luận
        $comments = Comment::where('article_id', $article->article_id)
            ->where('status', 'approved')
            ->whereNull('parent_id') // Chỉ lấy bình luận gốc
            ->with([
                'user:user_id,username,image',
                'reactions',
            ])
            ->withCount([
                'reactions as like_count' => function ($query) {
                    $query->where('is_like', true);
                },
                'reactions as dislike_count' => function ($query) {
                    $query->where('is_like', false);
                },
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(4); // Phân trang bình luận gốc (5 bình luận mỗi trang)

        // ✅ Lấy tất cả các replies của các bình luận đã phân trang
        $commentIds = $comments->pluck('comment_id'); // Lấy danh sách ID của bình luận gốc

        $replies = Comment::whereIn('parent_id',
            $commentIds) // Chỉ lấy replies của bình luận gốc
            ->where('status', 'approved')
            ->with([
                'user:user_id,username,image',
                'reactions',
            ])
            ->withCount([
                'reactions as like_count' => function ($query) {
                    $query->where('is_like', true);
                },
                'reactions as dislike_count' => function ($query) {
                    $query->where('is_like', false);
                },
            ])
            ->orderBy('created_at',
                'asc') // Hiển thị replies theo thứ tự cũ -> mới
            ->get();

        // ✅ Gán replies vào từng comment
        $groupedReplies = $replies->groupBy('parent_id');

        foreach ($comments as $comment) {
            $comment->replies = $groupedReplies->get($comment->comment_id,
                collect()); // Gán danh sách replies vào từng comment
        }

        $categories = Category::where('is_active', 1)->get();

        return view('client.articles.article',
            compact('categories', 'article', 'relatedArticles', 'isLiked',
                'likeCount', 'comments'));
    }

    public function likeArticle(Request $request, $article_id)
    {
        $userId = auth()->id();

        if (! $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để like!',
            ]);
        }

        $like = ArticleLike::where('article_id', $article_id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            try {
                // Chỉ xóa nếu like thuộc về người dùng hiện tại
                ArticleLike::where('like_id', $like->like_id)
                    ->where('user_id', $userId)
                    ->delete();
                $liked = false;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi hủy like: '.$e->getMessage(),
                ]);
            }
        } else {
            ArticleLike::create([
                'article_id' => $article_id,
                'user_id' => $userId,
                'liked_at' => now(),
            ]);
            $liked = true;
        }

        $likeCount = ArticleLike::where('article_id', $article_id)->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likeCount' => $likeCount,
        ]);
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,article_id',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,comment_id',
        ]);

        // Truy vấn `parentComment` trước để tối ưu
        $parentComment = $request->parent_id ? Comment::find($request->parent_id) : null;

        $comment = Comment::create([
            'article_id' => $request->article_id,
            'user_id' => auth()->id(),
            'content' => nl2br(e($request->content)), // Escape XSS
            'parent_id' => $request->parent_id,
            'depth' => $parentComment ? $parentComment->depth + 1 : 0,
            'status' => 'approved',
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'comment_id' => $comment->comment_id,
                'parent_id' => $comment->parent_id,
                'depth' => $comment->depth, // Trả depth về FE
                'content' => $comment->content,
                'username' => auth()->user()->username,
                'user_image' => auth()->user()->image ?? 'assets/img/colums/default.png',
                'created_at' => $comment->created_at->format('F d, Y'),
            ],
        ]);
    }

    public function storeReplyComment(
        Request $request,
        $article_id,
        $comment_id
    ) {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Kiểm tra xem comment gốc có tồn tại không
        $parentComment = Comment::where('comment_id', $comment_id)
            ->firstOrFail();

        // Tạo comment trả lời
        $reply = new Comment;
        $reply->content = $request->input('content');
        $reply->parent_id = $parentComment->comment_id; // ✅ Dùng comment_id thay vì id
        $reply->article_id = $article_id;
        $reply->user_id = auth()->id();
        $reply->depth = $parentComment->depth + 1; // Tăng depth dựa trên comment cha
        $reply->status = 'approved'; // ✅ Thêm cột status (có thể thay đổi theo yêu cầu)
        $reply->save();

        return response()->json([
            'success' => true,
            'reply' => [
                'comment_id' => $reply->comment_id,
                // ✅ Trả về comment_id thay vì id
                'username' => auth()->user()->username,
                'user_image' => auth()->user()->image ?? asset('assets/img/colums/default.png'),
                'content' => nl2br(e($reply->content)),
                'status' => $reply->status,
                // ✅ Trả về trạng thái của comment
                'created_at' => $reply->created_at->format('F d, Y'),
            ],
        ]);
    }
}
