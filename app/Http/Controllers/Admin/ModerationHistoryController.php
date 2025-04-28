<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModerationLog;
use App\Models\Article;

use App\Models\User;
use Illuminate\Http\Request;

class ModerationHistoryController extends Controller
{
    /**
     * Hiển thị danh sách tất cả lịch sử kiểm duyệt
     */
    public function index(Request $request)
    {
        try {
            // Kiểm tra xem bảng moderation_logs có tồn tại không
            if (!\Illuminate\Support\Facades\Schema::hasTable('moderation_logs')) {
                return view('admin.moderation.history', [
                    'logs' => collect([]),
                    'articles' => Article::select('article_id', 'title')->get(),
                    'users' => User::select('user_id', 'username')->get(),
                    'error' => 'Bảng moderation_logs không tồn tại trong cơ sở dữ liệu.'
                ]);
            }

            // Lấy tất cả dữ liệu mà không có điều kiện lọc ban đầu
            $query = \Illuminate\Support\Facades\DB::table('moderation_logs')
                ->leftJoin('users', 'moderation_logs.moderator_id', '=', 'users.user_id')
                ->select('moderation_logs.*', 'users.username')
                ->orderBy('moderation_logs.created_at', 'desc');

            // Lọc theo loại nội dung
            if ($request->has('content_type') && $request->content_type != 'all') {
                $query->where('moderation_logs.content_type', $request->content_type);
            }

            // Lọc theo loại hành động
            if ($request->has('action_type') && $request->action_type != 'all') {
                $query->where('moderation_logs.action_type', $request->action_type);
            }

            // Lọc theo mức độ nghiêm trọng
            if ($request->has('severity') && $request->severity != 'all') {
                $query->where('moderation_logs.severity', $request->severity);
            }

            // Lọc theo ID nội dung (bài viết, bình luận hoặc người dùng)
            if ($request->has('content_id') && !empty($request->content_id)) {
                $query->where('moderation_logs.content_id', intval($request->content_id));
            }

            // Lọc theo người kiểm duyệt
            if ($request->has('moderator_id') && !empty($request->moderator_id)) {
                $query->where('moderation_logs.moderator_id', intval($request->moderator_id));
            }

            // Lọc theo khoảng thời gian
            if ($request->has('date_from') && !empty($request->date_from)) {
                $query->whereDate('moderation_logs.created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to') && !empty($request->date_to)) {
                $query->whereDate('moderation_logs.created_at', '<=', $request->date_to);
            }

            $logs = $query->paginate(15);

            // Lấy danh sách bài viết và người dùng để hiển thị trong dropdown lọc
            $articles = Article::select('article_id', 'title')->get();
            $users = User::select('user_id', 'username')->get();

            return view('admin.moderation.history', compact('logs', 'articles', 'users'));
        } catch (\Exception $e) {
            // Ghi log lỗi
            \Illuminate\Support\Facades\Log::error('Lỗi khi truy vấn lịch sử kiểm duyệt: ' . $e->getMessage());

            // Trả về view với thông báo lỗi
            return view('admin.moderation.history', [
                'logs' => collect([]),
                'articles' => Article::select('article_id', 'title')->get(),
                'users' => User::select('user_id', 'username')->get(),
                'error' => 'Có lỗi xảy ra khi truy vấn dữ liệu: ' . $e->getMessage()
            ]);
        }
    }
}
