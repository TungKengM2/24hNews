<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleSave;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleSaveFactory extends Factory
{
    protected $model = ArticleSave::class;

    public function definition(): array
    {
        // Lấy tất cả các cặp article_id và user_id đã tồn tại
        $existingPairs = ArticleSave::select('article_id', 'user_id')->get()
            ->map(function ($item) {
                return $item->article_id . '-' . $item->user_id;
            })->toArray();

        // Tạo cặp article_id và user_id mới
        $articleId = Article::where('status', 'published')->inRandomOrder()->first()->article_id ??
                    Article::factory()->published()->create()->article_id;
        $userId = User::inRandomOrder()->first()->user_id ??
                 User::factory()->create()->user_id;

        // Đảm bảo cặp giá trị là duy nhất
        $attempts = 0;
        $maxAttempts = 10;

        while (in_array("$articleId-$userId", $existingPairs) && $attempts < $maxAttempts) {
            $articleId = Article::where('status', 'published')->inRandomOrder()->first()->article_id ??
                        Article::factory()->published()->create()->article_id;
            $userId = User::inRandomOrder()->first()->user_id ??
                     User::factory()->create()->user_id;
            $attempts++;
        }

        // Nếu không tìm được cặp duy nhất sau nhiều lần thử, tạo bài viết mới
        if ($attempts >= $maxAttempts) {
            $articleId = Article::factory()->published()->create()->article_id;
        }

        return [
            'article_id' => $articleId,
            'user_id' => $userId,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
