<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Approval;
use App\Models\User;
use App\Models\ModerationLog;
use App\Notifications\ArticleStatusUpdated;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessPendingArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-pending-articles {--minutes=30 : Thời gian chờ tối đa tính bằng phút}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xử lý các bài viết đang chờ duyệt quá thời gian quy định';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minutes = $this->option('minutes');
        $this->info("Đang xử lý bài viết chờ duyệt quá {$minutes} phút...");

        try {
            // Tìm các bài viết đang chờ duyệt
            $pendingArticles = Article::where('status', 'pending')
                ->where('created_at', '<=', Carbon::now()->subMinutes($minutes))
                ->get();

            $count = $pendingArticles->count();
            $this->info("Tìm thấy {$count} bài viết đang chờ duyệt quá {$minutes} phút.");

            foreach ($pendingArticles as $article) {
                $this->processArticle($article);
            }

            $this->info("Hoàn tất xử lý.");
        } catch (\Exception $e) {
            $this->error("Lỗi khi xử lý bài viết chờ duyệt: " . $e->getMessage());
            Log::error("Lỗi xử lý bài viết chờ duyệt: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    /**
     * Xử lý từng bài viết
     */
    private function processArticle(Article $article)
    {
        $this->line("Đang xử lý bài viết ID: {$article->article_id}, tiêu đề: {$article->title}");

        // Lưu trạng thái trước khi cập nhật
        $beforeState = [
            'status' => $article->status,
            'approved_by' => $article->approved_by
        ];

        // Tìm admin mặc định để xử lý tự động
        $admin = User::where('role_id', 1)->first();
        
        if (!$admin) {
            $this->warn("Không tìm thấy admin để xử lý tự động.");
            return;
        }

        // Cập nhật trạng thái bài viết thành rejected
        $article->update([
            'status' => 'rejected',
            'approved_by' => $admin->user_id,
            'rejection_reason' => 'Bài viết bị từ chối tự động do quá thời gian chờ duyệt (30 phút)'
        ]);

        // Cập nhật bản ghi Approval
        $approval = Approval::where('article_id', $article->article_id)->first();
        if ($approval) {
            $approval->update([
                'status' => 'rejected',
                'approved_by' => $admin->user_id,
                'remarks' => 'Bài viết bị từ chối tự động do quá thời gian chờ duyệt (30 phút)',
                'auto_reviewed' => true
            ]);
        } else {
            Approval::create([
                'article_id' => $article->article_id,
                'type' => 'article',
                'user_id' => $article->author_id,
                'status' => 'rejected',
                'approved_by' => $admin->user_id,
                'remarks' => 'Bài viết bị từ chối tự động do quá thời gian chờ duyệt (30 phút)',
                'auto_reviewed' => true
            ]);
        }

        // Lưu trạng thái sau khi cập nhật
        $afterState = [
            'status' => 'rejected',
            'approved_by' => $admin->user_id,
            'rejection_reason' => 'Bài viết bị từ chối tự động do quá thời gian chờ duyệt (30 phút)'
        ];

        // Tạo log kiểm duyệt
        try {
            ModerationLog::createLog(
                'reject',
                'article',
                $article->article_id,
                [
                    'title' => $article->title,
                    'author_id' => $article->author_id,
                    'category_id' => $article->category_id,
                    'action' => 'Từ chối tự động sau 30 phút chờ duyệt'
                ],
                $beforeState,
                $afterState,
                'Quá thời gian chờ duyệt'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
        }

        // Gửi thông báo cho tác giả
        if ($article->author) {
            $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã bị từ chối tự động do quá thời gian chờ duyệt (30 phút)."));
        }

        $this->info("Đã từ chối tự động bài viết: {$article->title}");
    }
} 