<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleUpgradeModerationLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Thêm một số bản ghi mẫu cho nâng cấp vai trò
        DB::table('moderation_logs')->insert([
            [
                'action_type' => 'approve',
                'content_type' => 'role_upgrade',
                'content_id' => 2, // ID người dùng
                'moderator_id' => 1, // ID người kiểm duyệt
                'details' => json_encode([
                    'action' => 'Nâng cấp vai trò người dùng',
                    'username' => 'user2',
                    'requested_role' => 'author',
                    'approval_id' => 1
                ]),
                'before_state' => json_encode([
                    'role_id' => 4,
                    'approval_status' => 'pending'
                ]),
                'after_state' => json_encode([
                    'role_id' => 2,
                    'approval_status' => 'approved'
                ]),
                'severity' => 'medium',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5)
            ],
            [
                'action_type' => 'reject',
                'content_type' => 'role_upgrade',
                'content_id' => 3, // ID người dùng
                'moderator_id' => 1, // ID người kiểm duyệt
                'details' => json_encode([
                    'action' => 'Từ chối nâng cấp vai trò người dùng',
                    'username' => 'user3',
                    'requested_role' => 'author',
                    'approval_id' => 2
                ]),
                'before_state' => json_encode([
                    'role_id' => 4,
                    'approval_status' => 'pending'
                ]),
                'after_state' => json_encode([
                    'role_id' => 4,
                    'approval_status' => 'rejected'
                ]),
                'severity' => 'medium',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4)
            ]
        ]);
    }
}
