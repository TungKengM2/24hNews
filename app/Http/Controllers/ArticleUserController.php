<?php

namespace App\Http\Controllers;


use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Violation;
use App\Models\ArticleLike;
use App\Models\ArticleSave;
use App\Models\ArticleView;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\CommentModerationService;

class ArticleUserController extends Controller
{
    public function show($slug)
    {
        $article = Article::with('tags', 'author')->where('slug', $slug)->firstOrFail();

        $userId = auth()->id();
        $userIp = request()->ip();

        // Kiểm tra xem user đã like bài viết chưa
        $isLiked = false;
        if ($userId) {
            $isLiked = ArticleLike::where(
                'article_id',
                $article->article_id
            )
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

        //BookMark By TungKeng
        $isBookmarked = false;
        if ($userId) { // Nếu có user đăng nhập
            $isBookmarked = ArticleSave::where('user_id', $userId)
                ->where('article_id', $article->article_id)
                ->exists();
        }


        // Lấy bài viết cùng author
        $relatedAuthorArticles = Article::where('author_id', $article->author_id)
            ->where('article_id', '!=', $article->article_id)
            ->withCount('comments')
            ->get(); // Trả về Collection

        // Chuyển thành mảng các article_id
        $relatedAuthorArticleIds = $relatedAuthorArticles->pluck('article_id')->toArray();

        // Lấy bài viết cùng danh mục nhưng không trùng với bài của tác giả trên
        $relatedCategoryArticles = Article::where('category_id', $article->category_id)
            ->whereNotIn('article_id', $relatedAuthorArticleIds) // Không lấy bài đã có trong danh sách tác giả
            ->where('article_id', '!=', $article->article_id) // Loại trừ bài hiện tại
            ->withCount('comments')
            ->get();

        //khuyencao
        $displayedArticleIds = array_merge(
            $relatedAuthorArticleIds,
            $relatedCategoryArticles->pluck('article_id')->toArray(),
            [$article->article_id]
        );
        $khuyencao = Article::whereNotIn('article_id', $displayedArticleIds)
            ->orderBy('views', 'desc') // Sắp xếp theo lượt xem cao nhất
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

        $replies = Comment::whereIn(
            'parent_id',
            $commentIds
        ) // Chỉ lấy replies của bình luận gốc
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
            ->orderBy(
                'created_at',
                'asc'
            ) // Hiển thị replies theo thứ tự cũ -> mới
            ->get();

        // ✅ Gán replies vào từng comment
        $groupedReplies = $replies->groupBy('parent_id');

        foreach ($comments as $comment) {
            $comment->replies = $groupedReplies->get(
                $comment->comment_id,
                collect()
            ); // Gán danh sách replies vào từng comment
        }

        $categories = Category::where('is_active', 1)->limit(7)->get();

        $category2 = Category::where('is_active', 1)->get();



        return view(
            'website.articles.article',
            compact(
                'category2',
                'categories',
                'article',
                'relatedAuthorArticles',
                'relatedCategoryArticles',
                'khuyencao',
                'isLiked',
                'likeCount',
                'comments',
                //TungKeng Bổ Sung
                'isBookmarked',
                // 'highlightCommentId'
            )
        );
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
                    'message' => 'Lỗi khi hủy like: ' . $e->getMessage(),
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

    public function storeComment(Request $request, CommentModerationService $moderationService)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,article_id',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,comment_id',
        ]);

        $content = $request->content;

        if (!$moderationService->checkComment($content)) {
            Log::warning("🚫 Bình luận bị từ chối: " . $content);
            return response()->json(['error' => 'Bình luận không được chấp nhận vì chứa từ ngữ không phù hợp.'], 403);
        }



        // Truy vấn `parentComment` trước để tối ưu
        $parentComment = $request->parent_id ? Comment::find($request->parent_id) : null;

        $comment = Comment::create([
            'article_id' => $request->article_id,
            'user_id' => auth()->id(),
            'content' => nl2br(e($request->content)), // Escape XSS
            'parent_id' => $request->parent_id,
            'depth' => $parentComment ? $parentComment->depth + 1 : 0,
            'status' => 'approved',
            'created_at' => now(), // Thời gian tạo comment
            'updated_at' => now(), // Thời gian cập nhật comment
        ]);
        

        return response()->json([
            'success' => true,
            'message' => 'Bạn Comment thành công!',

        ]);
    }

    public function storeReplyComment(Request $request, CommentModerationService $moderationService)
    {

        $request->validate([
            'article_id' => 'required|exists:articles,article_id',
            'content' => 'required|string',
            'parent_id' => 'required|exists:comments,comment_id',
        ]);

        $content = $request->content;

        if (!$moderationService->checkComment($content)) {
            Log::warning("🚫 Bình luận bị từ chối: " . $content);
            return response()->json(['error' => 'Bình luận không được chấp gggg nhận vì chứa từ ngữ không phù hợp.'], 403);
        }

        // Truy vấn `parentComment` trước để tối ưu
        $parentComment = Comment::find($request->parent_id);

        $reply = Comment::create([
            'article_id' => $request->article_id,
            'user_id' => auth()->id(),
            'content' => nl2br(e($request->content)), // Escape XSS
            'parent_id' => $request->parent_id,
            'depth' => $parentComment ? $parentComment->depth + 1 : 0,
            'status' => 'approved',
            'created_at' => now(), // Thời gian tạo comment
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bạn trả lời bình luận thành công!',
        ]);
    }

    public function reportComment(Request $request, $article_id, $comment_id)
    {
        // Validate dữ liệu: chỉ cần kiểm tra 'reason' nếu có (article_id và comment_id lấy từ route)
        $request->validate([
            'reason' => 'nullable|string'
        ]);

        try {
            // Tìm bài viết dựa trên article_id
            $article = Article::findOrFail($article_id);
            // Tìm bình luận gốc cần repost theo comment_id
            $originalComment = Comment::findOrFail($comment_id);

            // Xác định nội dung repost: nếu có nhập 'reason' thì dùng, nếu không dùng nội dung của bình luận gốc.
            $content = $request->input('reason') ?: $originalComment->content;
            // Vì trường detected_word của violations có độ dài 50 ký tự, cắt gọn nếu cần.
            $detected_word = substr($content, 0, 50);


            // Ghi nhận thông tin repost vào bảng violations với trạng thái "pending"
            Violation::create([
                'type'          => 'comment',
                'reference_id'  => $comment_id,  // ID của repost vừa tạo
                'detected_word' => $detected_word,
                'detected_at'   => now(),
                'handled_by'    => null,
                'status'        => 'pending',         // Theo migration, mặc định là 'pending'
                'warning_sent'  => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Repost đã gửi lên chờ xử lý.'
            ]);
        } catch (\Exception $e) {
            Log::error("Error in repostComment", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reportArticle(Request $request, $article_id)
    {
        // Validate dữ liệu: 'reason' là nullable string
        $request->validate([
            'reason' => 'nullable|string'
        ]);

        try {
            // Tìm bài viết gốc cần repost
            $originalArticle = Article::findOrFail($article_id);

            // Xác định nội dung repost: nếu có nhập 'reason' thì dùng, nếu không dùng nội dung bài viết gốc
            $content = $request->input('reason') ?: $originalArticle->content;
            // Lấy 50 ký tự đầu làm detected_word (loại bỏ HTML)
            $detected_word = substr(strip_tags($content), 0, 50);

            DB::beginTransaction();



            // Ghi nhận thông tin violation cho repost bài viết
            Violation::create([
                'type'          => 'article',
                'reference_id'  => $article_id, // ID của bài repost mới tạo
                'detected_word' => $detected_word,
                'detected_at'   => now(),
                'handled_by'    => null,
                'status'        => 'pending',
                'warning_sent'  => false
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Repost bài viết đã gửi lên chờ xử lý.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error in repostArticle", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
