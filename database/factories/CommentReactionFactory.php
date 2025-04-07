<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentReactionFactory extends Factory
{
    protected $model = CommentReaction::class;

    public function definition(): array
    {
        return [
            'comment_id' => Comment::inRandomOrder()->first()->comment_id ??
                           Comment::factory()->create()->comment_id,
            'user_id' => User::inRandomOrder()->first()->user_id ??
                        User::factory()->create()->user_id,
            'is_like' => $this->faker->boolean(70), // 70% chance to be a like
            'reacted_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            // Không có created_at và updated_at vì bảng không có các cột này
        ];
    }

    // Tạo reaction là like
    public function like(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'is_like' => true,
            ];
        });
    }

    // Tạo reaction là dislike
    public function dislike(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'is_like' => false,
            ];
        });
    }
}
