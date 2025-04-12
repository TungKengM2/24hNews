<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleEditRequest;
use App\Notifications\ArticleEditRequestExpired;
use App\Notifications\ArticleEditingExpired;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessArticleEditRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:process-edit-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process expired article edit requests and editing periods';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->processExpiredEditRequests();
        $this->processExpiredEditingPeriods();
    }

    /**
     * Process expired edit requests (not approved within 1 hour)
     */
    private function processExpiredEditRequests()
    {
        $expiredRequests = ArticleEditRequest::where('status', 'pending')
            ->where('request_expires_at', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredRequests as $request) {
            try {
                $request->update([
                    'status' => 'rejected',
                    'admin_note' => 'Yêu cầu tự động bị từ chối do hết thời gian chờ phê duyệt (1 giờ).'
                ]);

                // Notify author
                \App\Helpers\NotificationHelper::sendCustomNotification(
                    $request->author,
                    'Yêu cầu chỉnh sửa đã hết hạn',
                    'Yêu cầu chỉnh sửa bài viết "' . $request->article->title . '" đã hết hạn do không được xử lý kịp thời.',
                    'edit_request_expired',
                    [
                        'article_id' => $request->article_id,
                        'request_id' => $request->id
                    ]
                );

                $count++;
                $this->info("Processed expired edit request ID: {$request->id} for article: {$request->article->title}");
            } catch (\Exception $e) {
                Log::error("Error processing expired edit request ID: {$request->id}: " . $e->getMessage());
                $this->error("Error processing expired edit request ID: {$request->id}: " . $e->getMessage());
            }
        }

        $this->info("Processed {$count} expired edit requests");
    }

    /**
     * Process expired editing periods (not reviewed within 30 minutes)
     */
    private function processExpiredEditingPeriods()
    {
        // 1. Process articles that have been edited and are in 'editing' status
        $expiredEdits = Article::where('status', 'editing')
            ->whereHas('editRequests', function($query) {
                $query->where('edit_expires_at', '<', now())
                    ->where('status', 'approved');
            })
            ->get();

        $count = 0;
        foreach ($expiredEdits as $article) {
            try {
                // Check if the article has been edited (by comparing updated_at with edit_request created_at)
                $editRequest = $article->editRequests()
                    ->where('status', 'approved')
                    ->where('edit_expires_at', '<', now())
                    ->latest()
                    ->first();

                if ($editRequest) {
                    $hasBeenEdited = $article->updated_at > $editRequest->created_at;

                    if ($hasBeenEdited) {
                        // If edited but not reviewed in time, reject it
                        $article->update(['status' => 'rejected']);

                        $editRequest->update([
                            'status' => 'rejected',
                            'admin_note' => 'Bài viết tự động bị từ chối do hết thời gian chỉnh sửa (30 phút).'
                        ]);

                        // Notify author
                        \App\Helpers\NotificationHelper::sendCustomNotification(
                            $article->author,
                            'Thời gian chỉnh sửa đã hết hạn',
                            'Bài viết "' . $article->title . '" đã bị từ chối do không được duyệt lại kịp thời sau khi chỉnh sửa.',
                            'editing_expired',
                            [
                                'article_id' => $article->article_id
                            ]
                        );

                        $this->info("Processed expired editing period for article ID: {$article->article_id}, title: {$article->title} - REJECTED");
                    } else {
                        // If not edited, revert to published status
                        $article->update(['status' => 'published']);

                        $editRequest->update([
                            'status' => 'expired',
                            'admin_note' => 'Yêu cầu chỉnh sửa đã hết hạn do không được chỉnh sửa trong thời gian quy định (30 phút).'
                        ]);

                        // Notify author
                        \App\Helpers\NotificationHelper::sendCustomNotification(
                            $article->author,
                            'Yêu cầu chỉnh sửa đã hết hạn',
                            'Yêu cầu chỉnh sửa bài viết "' . $article->title . '" đã hết hạn do không được chỉnh sửa trong thời gian quy định.',
                            'edit_request_expired',
                            [
                                'article_id' => $article->article_id,
                                'request_id' => $editRequest->id
                            ]
                        );

                        $this->info("Processed expired editing period for article ID: {$article->article_id}, title: {$article->title} - REVERTED TO PUBLISHED");
                    }

                    $count++;
                }
            } catch (\Exception $e) {
                Log::error("Error processing expired editing period for article ID: {$article->article_id}: " . $e->getMessage());
                $this->error("Error processing expired editing period for article ID: {$article->article_id}: " . $e->getMessage());
            }
        }

        $this->info("Processed {$count} expired editing periods");
    }
}
