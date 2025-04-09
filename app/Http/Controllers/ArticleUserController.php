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
        $article = Article::with('tags', 'author', 'category') // Dùng 'category' thay vì 'categories'
            ->where('slug', $slug)
            ->where('status', 'published') // Lọc bài viết đã xuất bản
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->firstOrFail();



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


        // Lấy bài viết cùng author (đã xuất bản, danh mục đang hoạt động)
        $relatedAuthorArticles = Article::where('author_id', $article->author_id)
            ->where('article_id', '!=', $article->article_id)
            ->where('status', 'published') // Chỉ lấy bài viết đã xuất bản
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->withCount('comments')
            ->get();

        // Chuyển thành mảng các article_id
        $relatedAuthorArticleIds = $relatedAuthorArticles->pluck('article_id')->toArray();

        // Lấy bài viết cùng danh mục nhưng không trùng với bài của tác giả trên
        $relatedCategoryArticles = Article::where('category_id', $article->category_id)
            ->whereNotIn('article_id', $relatedAuthorArticleIds) // Không lấy bài đã có trong danh sách tác giả
            ->where('article_id', '!=', $article->article_id) // Loại trừ bài hiện tại
            ->where('status', 'published') // Chỉ lấy bài viết đã xuất bản
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->withCount('comments')
            ->get();

        // Danh sách ID đã hiển thị
        $displayedArticleIds = array_merge(
            $relatedAuthorArticleIds,
            $relatedCategoryArticles->pluck('article_id')->toArray(),
            [$article->article_id]
        );

        // Lấy bài viết khuyến cáo (tránh bài đã hiển thị, sắp xếp theo lượt xem cao nhất)
        $khuyencao = Article::whereNotIn('article_id', $displayedArticleIds)
            ->where('status', 'published') // Chỉ lấy bài viết đã xuất bản
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1); // Danh mục phải đang hoạt động
            })
            ->orderBy('views', 'desc')
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

        $category2 = Category::withCount(['articles' => function ($query) {
            $query->where('status', 'published'); // Điều kiện bài viết có trạng thái 'published'
        }])->where('is_active', 1)->get();





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
        $articleId = $request->article_id;
        $userId = auth()->id();

        // Create a temporary comment to get an ID for logging
        $tempComment = new Comment([
            'article_id' => $articleId,
            'user_id' => $userId,
            'content' => nl2br(e($content)),
            'parent_id' => $request->parent_id,
            'depth' => 0,
            'status' => 'pending',
        ]);
        $tempComment->save();

        if (!$moderationService->checkComment($content, $tempComment->comment_id, $userId, $articleId)) {
            Log::warning("🚫 Bình luận bị từ chối: " . $content);

            // Update the comment status to rejected
            $tempComment->status = 'rejected';
            $tempComment->save();

            return response()->json(['error' => 'Bình luận không được chấp nhận vì chứa từ ngữ không phù hợp.'], 403);
        }

        // If comment passes moderation, update its status to approved
        $tempComment->status = 'approved';

        // Update depth if it's a reply
        if ($request->parent_id) {
            $parentComment = Comment::find($request->parent_id);
            if ($parentComment) {
                $tempComment->depth = $parentComment->depth + 1;
            }
        }

        $tempComment->save();

        // Create moderation log for approved comment
        try {
            \App\Models\ModerationLog::createLog(
                'auto_moderate',
                'comment',
                $tempComment->comment_id,
                [
                    'action' => 'Tự động duyệt bình luận',
                    'content' => strip_tags($tempComment->content),
                    'article_id' => $tempComment->article_id,
                    'user_id' => $tempComment->user_id,
                ],
                ['status' => 'pending'],
                ['status' => 'approved'],
                'low'
            );
        } catch (\Exception $e) {
            Log::error("❌ Lỗi khi tạo log kiểm duyệt: " . $e->getMessage());
        }

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
        $articleId = $request->article_id;
        $userId = auth()->id();
        $parentId = $request->parent_id;

        // Get parent comment for depth calculation
        $parentComment = Comment::find($parentId);
        $depth = $parentComment ? $parentComment->depth + 1 : 0;

        // Create a temporary comment to get an ID for logging
        $tempReply = new Comment([
            'article_id' => $articleId,
            'user_id' => $userId,
            'content' => nl2br(e($content)),
            'parent_id' => $parentId,
            'depth' => $depth,
            'status' => 'pending',
        ]);
        $tempReply->save();

        if (!$moderationService->checkComment($content, $tempReply->comment_id, $userId, $articleId)) {
            Log::warning("🚫 Bình luận trả lời bị từ chối: " . $content);

            // Update the comment status to rejected
            $tempReply->status = 'rejected';
            $tempReply->save();

            return response()->json(['error' => 'Bình luận không được chấp nhận vì chứa từ ngữ không phù hợp.'], 403);
        }

        // If reply passes moderation, update its status to approved
        $tempReply->status = 'approved';
        $tempReply->save();

        // Create moderation log for approved reply
        try {
            \App\Models\ModerationLog::createLog(
                'auto_moderate',
                'comment',
                $tempReply->comment_id,
                [
                    'action' => 'Tự động duyệt bình luận trả lời',
                    'content' => strip_tags($tempReply->content),
                    'article_id' => $tempReply->article_id,
                    'user_id' => $tempReply->user_id,
                    'parent_id' => $tempReply->parent_id,
                ],
                ['status' => 'pending'],
                ['status' => 'approved'],
                'low'
            );
        } catch (\Exception $e) {
            Log::error("❌ Lỗi khi tạo log kiểm duyệt: " . $e->getMessage());
        }

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

            // Tìm chính xác bình luận bị báo cáo
            $comment = Comment::where('article_id', $article_id)
                ->where('comment_id', $comment_id) // Chắc chắn lấy đúng comment cần báo cáo
                ->firstOrFail();

            // Xác định nội dung báo cáo: nếu có nhập 'reason' thì dùng, nếu không dùng nội dung của bình luận
            $content = $request->input('reason') ?: $comment->content;  // Sử dụng nội dung bình luận hoặc lý do người dùng nhập
            // Cắt nội dung nếu cần để đảm bảo độ dài trường 'detected_word' không vượt quá 50 ký tự
            $detected_word = substr($content, 0, 50);

            // Ghi nhận thông tin vào bảng violations với trạng thái "pending"
            Violation::create([
                'type'          => 'comment',
                'reference_id'  => $comment->comment_id, // Sử dụng comment_id của bình luận báo cáo
                'detected_word' => $detected_word,
                'detected_at'   => now(),
                'handled_by'    => null,
                'status'        => 'pending',  // Mặc định là 'pending'
                'warning_sent'  => false
            ]);

            // Trả về phản hồi thành công
            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được báo cáo và chờ xử lý.'
            ]);
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error("Error in reportComment", ['error' => $e->getMessage()]);
            // Trả về phản hồi lỗi
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
    public function destroy($comment_id)
    {
        // Find the comment by its comment_id
        $comment = Comment::findOrFail($comment_id);
        if (auth()->id() === $comment->user_id) {
            $comment->delete();
        }


        // Check if the authenticated user is the owner of the comment
        if (auth()->id() === $comment->user_id) {
            // Delete the comment
            $comment->delete();

            // Flash success message and return back
            return back()->with('success', 'Đã xóa bình luận');
        }

        // If the user is not the owner, abort with a 403 error
        abort(403);
    }
}
