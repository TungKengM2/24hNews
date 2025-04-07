<?php

namespace Database\Factories;

use App\Helpers\CodeHelper;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence() . ' ' . uniqid();
        $content = '<p>' . implode('</p><p>', $this->faker->paragraphs(rand(5, 15))) . '</p>';
        $previewContent = $this->faker->paragraph();

        // Lấy ngẫu nhiên một author (role_id = 2)
        $authorId = User::where('role_id', 2)->inRandomOrder()->first()->user_id ??
                   User::factory()->create(['role_id' => 2])->user_id;

        // Lấy ngẫu nhiên một category
        $categoryId = Category::where('is_active', true)->inRandomOrder()->first()->category_id ??
                     Category::factory()->create(['is_active' => true])->category_id;

        // Lấy ngẫu nhiên một admin (role_id = 1) làm người phê duyệt
        $approverId = User::where('role_id', 1)->inRandomOrder()->first()->user_id ?? null;

        $statuses = ['draft', 'pending', 'published', 'archived', 'rejected'];
        $status = $this->faker->randomElement($statuses);

        // Nếu status là published, đảm bảo có approved_by
        if ($status === 'published' && $approverId === null) {
            $approverId = User::factory()->create(['role_id' => 1])->user_id;
        }

        return [
            'title' => $title,
            'code' => CodeHelper::generateArticleCode(),
            'slug' => Str::slug($title),
            'content' => $content,
            'preview_content' => $previewContent,
            'contains_sensitive_content' => $this->faker->boolean(10), // 10% chance to contain sensitive content
            'author_id' => $authorId,
            'category_id' => $categoryId,
            'thumbnail_url' => 'thumbnails/' . $this->faker->image('public/storage/thumbnails', 1200, 630, null, false),
            'status' => $status,
            'views' => $this->faker->numberBetween(0, 1000),
            'approved_by' => ($status === 'published') ? $approverId : null,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    public function published(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
                'approved_by' => User::where('role_id', 1)->inRandomOrder()->first()->user_id ??
                                User::factory()->create(['role_id' => 1])->user_id,
            ];
        });
    }

    public function draft(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
                'approved_by' => null,
            ];
        });
    }

    public function pending(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'approved_by' => null,
            ];
        });
    }
}
