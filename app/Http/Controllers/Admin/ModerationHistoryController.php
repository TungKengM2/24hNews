<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModerationLog;
use App\Models\Article;
use App\Models\Comment;
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
            // Thêm log để kiểm tra
            \Illuminate\Support\Facades\Log::info('Truy vấn lịch sử kiểm duyệt');

            // Kiểm tra xem bảng moderation_logs có tồn tại không
            if (!\Illuminate\Support\Facades\Schema::hasTable('moderation_logs')) {
                \Illuminate\Support\Facades\Log::error('Bảng moderation_logs không tồn tại');
                return view('admin.moderation.history', [
                    'logs' => collect([]),
                    'articles' => Article::select('article_id', 'title')->get(),
                    'comments' => Comment::select('comment_id', 'content')->limit(100)->get(),
                    'users' => User::select('user_id', 'username')->get(),
                    'error' => 'Bảng moderation_logs không tồn tại trong cơ sở dữ liệu.'
                ]);
            }

            // Đếm số lượng bản ghi trong bảng moderation_logs
            $count = \Illuminate\Support\Facades\DB::table('moderation_logs')->count();
            \Illuminate\Support\Facades\Log::info('Số lượng bản ghi trong bảng moderation_logs: ' . $count);

            // Lấy và ghi log 5 bản ghi đầu tiên để kiểm tra
            if ($count > 0) {
                $sampleRecords = \Illuminate\Support\Facades\DB::table('moderation_logs')->limit(5)->get();
                \Illuminate\Support\Facades\Log::info('Mẫu 5 bản ghi đầu tiên:', ['records' => json_encode($sampleRecords)]);
            }

            // Lấy tất cả dữ liệu mà không có điều kiện lọc ban đầu
            $query = \Illuminate\Support\Facades\DB::table('moderation_logs')
                ->leftJoin('users', 'moderation_logs.moderator_id', '=', 'users.user_id')
                ->select('moderation_logs.*', 'users.username')
                ->orderBy('moderation_logs.created_at', 'desc');

            // Lọc theo loại nội dung
            if ($request->has('content_type') && in_array($request->content_type, ['article', 'comment', 'role_upgrade'])) {
                $query->where('moderation_logs.content_type', $request->content_type);
            } elseif (!$request->has('content_type') || $request->content_type == 'all') {
                // Không lọc theo loại nội dung nếu chọn 'all' hoặc không chọn gì
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
                $query->where('moderation_logs.content_id', $request->content_id);
            }

            // Lọc theo người kiểm duyệt
            if ($request->has('moderator_id') && !empty($request->moderator_id)) {
                $query->where('moderation_logs.moderator_id', $request->moderator_id);
            }

            // Lọc theo khoảng thời gian
            if ($request->has('date_from') && !empty($request->date_from)) {
                $query->whereDate('moderation_logs.created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to') && !empty($request->date_to)) {
                $query->whereDate('moderation_logs.created_at', '<=', $request->date_to);
            }

            // Ghi log câu truy vấn SQL
            $bindings = $query->getBindings();
            $sqlWithPlaceholders = str_replace(['?'], ['\'%s\''], $query->toSql());
            $sql = vsprintf($sqlWithPlaceholders, $bindings);
            \Illuminate\Support\Facades\Log::info('Câu truy vấn SQL: ' . $sql);

            $logs = $query->paginate(20);

            // Log số lượng kết quả trả về
            \Illuminate\Support\Facades\Log::info('Số lượng kết quả truy vấn: ' . $logs->count());

            // Nếu không có kết quả, thử truy vấn đơn giản hơn
            if ($logs->count() == 0) {
                $simpleQuery = \Illuminate\Support\Facades\DB::table('moderation_logs')
                    ->select('*')
                    ->limit(10)
                    ->get();
                \Illuminate\Support\Facades\Log::info('Kết quả truy vấn đơn giản:', ['records' => json_encode($simpleQuery)]);

                // Nếu có dữ liệu từ truy vấn đơn giản, sử dụng nó thay thế
                if ($simpleQuery->count() > 0) {
                    $logs = new \Illuminate\Pagination\LengthAwarePaginator(
                        $simpleQuery,
                        $simpleQuery->count(),
                        20,
                        1,
                        ['path' => \Illuminate\Support\Facades\Request::url()]
                    );
                    \Illuminate\Support\Facades\Log::info('Sử dụng kết quả truy vấn đơn giản thay thế');
                }
            }

            // Lấy danh sách bài viết, bình luận và người dùng để hiển thị trong dropdown lọc
            $articles = Article::select('article_id', 'title')->get();
            $comments = Comment::select('comment_id', 'content')->limit(100)->get();
            $users = User::select('user_id', 'username')->get();

            // Lấy dữ liệu mẫu trực tiếp từ bảng moderation_logs để hiển thị trong debug
            $sampleData = \Illuminate\Support\Facades\DB::table('moderation_logs')
                ->select('*')
                ->limit(5)
                ->get();

            return view('admin.moderation.history', compact('logs', 'articles', 'comments', 'users', 'sampleData'));
        } catch (\Exception $e) {
            // Ghi log lỗi
            \Illuminate\Support\Facades\Log::error('Lỗi khi truy vấn lịch sử kiểm duyệt: ' . $e->getMessage());

            // Trả về view với thông báo lỗi
            return view('admin.moderation.history', [
                'logs' => collect([]),
                'articles' => Article::select('article_id', 'title')->get(),
                'comments' => Comment::select('comment_id', 'content')->limit(100)->get(),
                'users' => User::select('user_id', 'username')->get(),
                'error' => 'Có lỗi xảy ra khi truy vấn dữ liệu: ' . $e->getMessage()
            ]);
        }
    }
}
