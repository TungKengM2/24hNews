<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\ArticleLike;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use App\Models\CommentReaction;
use Illuminate\Support\Facades\Log;

class ArticleUserController extends Controller
{
    public function show($article_id)
    {
        $article = Article::where('article_id', $article_id)->first();

        if (!$article) {
            abort(404, 'Bài viết không tồn tại!');
        }

        $userId = auth()->id();
        $userIp = request()->ip();

        // Kiểm tra xem user đã like bài viết chưa
        $isLiked = false;
        if ($userId) {
            $isLiked = ArticleLike::where('article_id', $article->article_id)
                ->where('user_id', $userId)
                ->exists();
        }

        // Lấy số lượt like
        $likeCount = ArticleLike::where('article_id', $article->article_id)->count();

        // Kiểm tra xem user đã xem bài viết chưa
        $hasViewed = ArticleView::where('article_id', $article->article_id)
            ->where(function ($query) use ($userId, $userIp) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->whereNull('user_id')->where('ip_address', $userIp);
                }
            })
            ->exists();

        // Nếu chưa xem, thêm vào database & tăng lượt xem
        if (!$hasViewed) {
            ArticleView::create([
                'article_id' => $article->article_id,
                'user_id' => $userId,
                'ip_address' => $userIp,
                'viewed_at' => now(),
            ]);

            $article->increment('views');
        }

        // Lấy bài viết liên quan
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('article_id', '!=', $article->article_id)
            ->limit(5)
            ->get();

        // Lấy danh sách bình luận
        $comments = Comment::where('article_id', $article->article_id)
            ->where('status', 'approved')
            ->with(['user:user_id,username', 'replies', 'reactions'])
            ->withCount([
                'reactions as like_count' => function ($query) {
                    $query->where('is_like', true);
                },
                'reactions as dislike_count' => function ($query) {
                    $query->where('is_like', false);
                }
            ])
            ->get();

        return view('client.articles.article', compact('article', 'relatedArticles', 'isLiked', 'likeCount', 'comments'));
    }

    public function likeArticle(Request $request, $article_id)
    {
        $userId = auth()->id();
    
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để like!']);
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
                return response()->json(['success' => false, 'message' => 'Lỗi khi hủy like: ' . $e->getMessage()]);
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
    
        return response()->json(['success' => true, 'liked' => $liked, 'likeCount' => $likeCount]);
    }
    
    


    public function storeComment(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,article_id',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,comment_id'
        ]);

        $badWords = ['tục1', 'tục2', 'tục3'];
        $cleanContent = str_ireplace($badWords, '***', $request->content);

        $comment = Comment::create([
            'article_id' => $request->article_id,
            'user_id' => auth()->id(),
            'content' => $cleanContent,
            'parent_id' => $request->parent_id,
            'depth' => $request->parent_id ? Comment::find($request->parent_id)->depth + 1 : 0,
            'status' => 'approved'
        ]);

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function likeComment($commentId)
    {
        return $this->handleCommentReaction($commentId, true);
    }

    public function dislikeComment($commentId)
    {
        return $this->handleCommentReaction($commentId, false);
    }

    public function react(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $userId = auth()->id();
        $isLike = $request->is_like;
    
        $reaction = CommentReaction::updateOrCreate(
            ['comment_id' => $commentId, 'user_id' => $userId],
            ['is_like' => $isLike, 'reacted_at' => now()]
        );
    
        $comment->likes = CommentReaction::where('comment_id', $commentId)->where('is_like', true)->count();
        $comment->dislikes = CommentReaction::where('comment_id', $commentId)->where('is_like', false)->count();
        $comment->save();
    
        return response()->json(['success' => true, 'count' => $isLike ? $comment->likes : $comment->dislikes]);
    }
    
    
    

    
    
}
