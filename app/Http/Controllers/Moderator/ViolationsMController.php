<?php

namespace App\Http\Controllers\Moderator;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewArticleSubmitted;
use App\Notifications\ArticleStatusUpdated;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ArticleStatusChangedNotification;


class ViolationsMController extends Controller
{
    /**
     *
     */
    public function approves(Request $request)
    {
        $query = Violation::query();

        // Lọc theo status nếu có
        if ($request->has('status') && in_array($request->status, ['pending', 'resolved'])) {
            $query->where('status', $request->status);
        }

        // Lấy danh sách vi phạm với eager load và phân trang
        $violations = Violation::with(['handledByUser', 'article', 'comments.user'])->paginate(10);


        return view('moderator.violations.approves', compact('violations'));
    }


    public function reject(Violation $violation)
    {
        if ($violation->status !== 'pending') {
            return back()->with('error', 'Vi phạm không còn trong trạng thái chờ duyệt!');
        }

        // Xóa vi phạm
        $violation->delete();

        return back()->with('success', 'Vi phạm đã bị từ chối.');
    }

    /**
     * Giải quyết vi phạm
     */
    public function resolve(Violation $violation)
    {
        // Kiểm tra trạng thái của vi phạm, chỉ xử lý nếu trạng thái là "pending"
        if ($violation->status !== 'pending') {
            return back()->with('error', 'Vi phạm không còn trong trạng thái chờ duyệt!');
        }
    
        // Lấy bình luận bị vi phạm dựa trên reference_id
        $comment = Comment::where('comment_id', $violation->reference_id)->first();
    
        if (!$comment) {
            return back()->with('error', 'Bình luận vi phạm không tồn tại hoặc đã bị xóa trước đó.');
        }
    
        // Tăng số lần vi phạm của người dùng (theo cách động)
        $user = User::find($comment->user_id);
        if ($user) {
            $daysSinceLast = $user->last_violation_at ? now()->diffInDays($user->last_violation_at) : 0;
            $realViolation = max(0, $user->violation_count - $daysSinceLast);
    
            $realViolation += 1; // Cộng thêm 1 lần vi phạm mới
            $user->violation_count = $realViolation;
            $user->last_violation_at = now();
            $user->save();
    
            // Áp dụng hình phạt nếu cần
            if ($realViolation >= 5) {
                $user->banned_until = now()->addDays(3);
                $user->save();
    
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã bị cấm bình luận 3 ngày do vi phạm quá nhiều.',
                ]);
            } elseif ($realViolation >= 3) {
                $user->banned_until = now()->addHours(24);
                $user->save();
    
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã bị tạm khóa bình luận trong 24 giờ vì vi phạm nhiều lần.',
                ]);
            }
        }
    
        // Xử lý các bình luận con
        $childComments = Comment::where('parent_id', $comment->comment_id)->get();
        if ($childComments->isNotEmpty()) {
            foreach ($childComments as $child) {
                $child->delete();
            }
        }
    
        // Xóa bình luận gốc và vi phạm
        $comment->delete();
        $violation->delete();
    
        return back()->with('success', 'Vi phạm đã được giải quyết, bình luận và tất cả phản hồi đã bị xóa.');
    }
    
    
    
    
    
    public function resolves(Violation $violation)
    {
        // Kiểm tra xem vi phạm có trạng thái 'pending' hay không
        if ($violation->status !== 'pending') {
            return back()->with('error', 'Vi phạm không còn trong trạng thái chờ duyệt!');
        }
    
        // Lấy bài viết bị vi phạm dựa trên reference_id
        $article = Article::where('article_id', $violation->reference_id)->first();
        if (!$article) {
            return back()->with('error', 'Không tìm thấy bài viết!');
        }
    
        // Tăng số lần vi phạm của người dùng theo cách tính động
        $user = User::find($article->user_id);
        if ($user) {
            $daysSinceLast = $user->last_violation_at ? now()->diffInDays($user->last_violation_at) : 0;
            $realViolation = max(0, $user->violation_count - $daysSinceLast);
    
            $realViolation += 1; // Vi phạm mới
    
            // Lưu lại giá trị mới
            $user->violation_count = $realViolation;
            $user->last_violation_at = now();
            $user->save();
    
            // Áp dụng hình phạt nếu vượt ngưỡng
            if ($realViolation >= 5) {
                $user->banned_until = now()->addDays(3);
                $user->save();
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã bị cấm bình luận 3 ngày do vi phạm quá nhiều.',
                ]);
            } elseif ($realViolation >= 3) {
                $user->banned_until = now()->addHours(24);
                $user->save();
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã bị tạm khóa bình luận trong 24 giờ vì vi phạm nhiều lần.',
                ]);
            }
        }
    
        // Cập nhật trạng thái bài viết thành "draft"
        $article->status = 'draft';
        $article->save();
    
        // Gửi thông báo
        $detectedWord = $violation->detected_word;
        $author = $article->author;
        $author->notify(new ArticleStatusChangedNotification($article, $detectedWord));
    
        // Xóa vi phạm
        $violation->delete();
    
        return back()->with('success', 'Vi phạm đã được giải quyết.');
    }
    
}
