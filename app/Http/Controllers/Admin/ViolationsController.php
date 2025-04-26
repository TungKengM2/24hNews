<?php

namespace App\Http\Controllers\Admin;

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
use App\Notifications\UserViolationAlert;
use App\Notifications\NewArticleSubmitted;
use App\Notifications\ArticleStatusUpdated;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ArticleStatusChangedNotification;

class ViolationsController extends Controller
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



        return view('admin.violations.approves', compact('violations'));
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
            $realViolation += 1;

            $user->violation_count = $realViolation;
            $user->last_violation_at = now();

            if ($realViolation >= 5) {
                $user->banned_until = now()->addDays(3);
            } elseif ($realViolation >= 3) {
                $user->banned_until = now()->addHours(24);
            }
            $user->save();
        }


        $usersToNotify = User::whereIn('violation_count', [3, 5])->get();
        foreach ($usersToNotify as $user) {
            $user->notify(new UserViolationAlert($user));
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





    public function resolves(Request $request, Violation $violation)
    {
        // Validate input lý do
        $request->validate(['reason' => 'required|string|max:1000']);

        // Kiểm tra trạng thái
        if ($violation->status !== 'pending') {
            return back()->with('error', 'Vi phạm không còn trong trạng thái chờ duyệt!');
        }

        // Tìm bài viết theo reference_id
        $article = Article::where('article_id', $violation->reference_id)->first();
        if (!$article) {
            return back()->with('error', 'Không tìm thấy bài viết!');
        }

        // Cập nhật số lần vi phạm và thời gian của user
        $user = User::find($article->author_id);
        if ($user) {
            $daysSinceLast = $user->last_violation_at ? now()->diffInDays($user->last_violation_at) : 0;
            $realViolation = max(0, $user->violation_count - $daysSinceLast);
            $realViolation += 1;

            $user->violation_count = $realViolation;
            $user->last_violation_at = now();

            if ($realViolation >= 5) {
                $user->banned_until = now()->addDays(3);
            } elseif ($realViolation >= 3) {
                $user->banned_until = now()->addHours(24);
            }

            $user->save();
        }
        // Đổi bài viết thành bản nháp
        $article->update(['status' => 'draft']);

        // Gửi thông báo cho tác giả với lý do
        $author = $article->author;
        $author->notify(new ArticleStatusChangedNotification(
            $article,
            $violation->detected_word,
            $request->reason
        ));

        // Xóa violation sau khi xử lý
        $violation->delete();

        // Trả về thông báo thành công
        return back()->with('success', 'Vi phạm đã được giải quyết với lý do: ' . $request->reason);
    }
}
