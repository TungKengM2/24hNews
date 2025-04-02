<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\Violation;
use Illuminate\Http\Request;
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

    /**
     * Giải quyết vi phạm
     */
    public function resolve(Violation $violation)
    {
        // Kiểm tra xem vi phạm có trạng thái 'pending' hay không
        if ($violation->status !== 'pending') {
            return back()->with('error', 'Vi phạm không còn trong trạng thái chờ duyệt!');
        }

        // Cập nhật trạng thái vi phạm thành 'resolved'
        $violation->status = 'resolved';
        $violation->handled_by = Auth::id(); // Gán người xử lý (có thể là người đăng nhập)
        $violation->save();

        return back()->with('success', 'Vi phạm đã được giải quyết.');
    }

    // ViolationController.php
    public function showDetails($violationId)
    {
        $violation = Violation::findOrFail($violationId);
        return view('admin.violations.details', compact('violation'));
    }
}
