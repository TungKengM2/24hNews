<?php

namespace Database\Seeders;

use App\Models\Approval;
use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\ArticleSave;
use App\Models\ArticleVersion;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RandomDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Đảm bảo thư mục thumbnails tồn tại
        if (!Storage::disk('public')->exists('thumbnails')) {
            Storage::disk('public')->makeDirectory('thumbnails');
        }

        // 1. Tạo roles (nếu chưa có)
        if (Role::count() === 0) {
            $this->call(RoleSeeder::class);
        }

        // 2. Tạo users (nếu chưa có đủ)
        if (User::count() < 10) {
            // Tạo thêm users
            User::factory(20)->create();

            // Đảm bảo có ít nhất 3 admin
            $adminCount = User::where('role_id', 1)->count();
            if ($adminCount < 3) {
                User::factory(3 - $adminCount)->create(['role_id' => 1]);
            }

            // Đảm bảo có ít nhất 5 author
            $authorCount = User::where('role_id', 2)->count();
            if ($authorCount < 5) {
                User::factory(5 - $authorCount)->create(['role_id' => 2]);
            }

            // Đảm bảo có ít nhất 3 moderator
            $moderatorCount = User::where('role_id', 3)->count();
            if ($moderatorCount < 3) {
                User::factory(3 - $moderatorCount)->create(['role_id' => 3]);
            }
        }

        // 3. Tạo categories
        Category::factory(10)->create();

        // 4. Tạo tags
        Tag::factory(20)->create();

        // 5. Tạo articles
        $articles = Article::factory(50)->create();

        // 6. Gán tags cho articles
        foreach ($articles as $article) {
            $tagIds = Tag::inRandomOrder()->limit(rand(2, 5))->pluck('tag_id')->toArray();
            $article->tags()->sync($tagIds);
        }

        // 7. Tạo article versions
        ArticleVersion::factory(100)->create();

        // 8. Tạo comments
        Comment::factory(100)->create();

        // 9. Tạo replies cho comments
        Comment::factory(50)->reply()->create();

        // 10. Tạo comment reactions
        CommentReaction::factory(200)->create();

        // 11. Tạo article likes
        ArticleLike::factory(150)->create();

        // 12. Tạo article saves (bookmarks)
        // Giảm số lượng để tránh xung đột
        ArticleSave::factory(30)->create();

        // 13. Tạo article views
        \App\Models\ArticleView::factory(300)->create();

        // 14. Tạo approvals
        Approval::factory(30)->forArticle()->create();
        Approval::factory(20)->forRoleUpgrade()->create();

        // 15. Tạo violations
        Violation::factory(15)->forArticle()->create();
        Violation::factory(10)->forComment()->create();
        Violation::factory(5)->forUser()->create();

        // 16. Tạo follows (người dùng theo dõi nhau)
        $users = User::all();
        foreach ($users as $follower) {
            // Mỗi người dùng theo dõi 1-5 người khác
            $followingCount = rand(1, 5);
            $followingIds = User::where('user_id', '!=', $follower->user_id)
                ->inRandomOrder()
                ->limit($followingCount)
                ->pluck('user_id');

            $follower->following()->sync($followingIds);
        }

        $this->command->info('Random data seeded successfully!');
    }
}
