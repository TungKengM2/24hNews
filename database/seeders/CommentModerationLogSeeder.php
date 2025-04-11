<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentModerationLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Thêm một số bản ghi mẫu cho bình luận
        DB::table('moderation_logs')->insert([
            [
                'action_type' => 'approve',
                'content_type' => 'comment',
                'content_id' => 1, // ID bình luận
                'moderator_id' => 1, // ID người kiểm duyệt
                'details' => json_encode([
                    'action' => 'Phê duyệt bình luận',
                    'content' => 'Nội dung bình luận mẫu',
                    'article_id' => 1,
                    'user_id' => 2,
                ]),
                'before_state' => json_encode([
                    'status' => 'pending',
                ]),
                'after_state' => json_encode([
                    'status' => 'approved',
                ]),
                'severity' => 'low',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3)
            ],
            [
                'action_type' => 'reject',
                'content_type' => 'comment',
                'content_id' => 2, // ID bình luận
                'moderator_id' => 1, // ID người kiểm duyệt
                'details' => json_encode([
                    'action' => 'Từ chối bình luận',
                    'content' => 'Nội dung bình luận không phù hợp',
                    'article_id' => 1,
                    'user_id' => 3,
                ]),
                'before_state' => json_encode([
                    'status' => 'pending',
                ]),
                'after_state' => json_encode([
                    'status' => 'rejected',
                ]),
                'severity' => 'medium',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2)
            ],
            [
                'action_type' => 'auto_moderate',
                'content_type' => 'comment',
                'content_id' => 3, // ID bình luận
                'moderator_id' => null,
                'details' => json_encode([
                    'action' => 'Tự động kiểm duyệt bình luận',
                    'content' => 'Nội dung bình luận tự động kiểm duyệt',
                    'article_id' => 2,
                    'user_id' => 4,
                ]),
                'before_state' => json_encode([
                    'status' => 'pending',
                ]),
                'after_state' => json_encode([
                    'status' => 'approved',
                ]),
                'severity' => 'low',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay()
            ]
        ]);
    }
}
