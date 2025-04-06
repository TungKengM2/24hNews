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
use App\Notifications\NewArticleSubmitted;
use App\Notifications\ArticleStatusUpdated;
use Illuminate\Support\Facades\Notification;

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

    // Lấy danh sách tất cả bình luận con của bình luận bị vi phạm
    $childComments = Comment::where('parent_id', $comment->comment_id)->get();

    // Kiểm tra nếu có bình luận con
    if ($childComments->isNotEmpty()) {
        foreach ($childComments as $child) {
            // Xóa bình luận con
            $child->delete();
        }
    }

    // Xóa bình luận cha sau khi đã xóa các bình luận con
    $comment->delete();

    // Xóa vi phạm khỏi bảng violations
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
        if ($article) {
            // Cập nhật trạng thái thành "draft"
            $article->status = 'draft';
            $article->save();
        }

        // Xóa vi phạm khỏi bảng violations
        $violation->delete();

        return back()->with('success', 'Vi phạm đã được giải quyết.');
    }
}
