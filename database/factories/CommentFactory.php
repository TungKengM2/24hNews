<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'article_id' => Article::where('status', 'published')->inRandomOrder()->first()->article_id ?? 
                           Article::factory()->published()->create()->article_id,
            'user_id' => User::inRandomOrder()->first()->user_id ?? 
                        User::factory()->create()->user_id,
            'content' => $this->faker->paragraph(rand(1, 5)),
            'likes' => $this->faker->numberBetween(0, 50),
            'dislikes' => $this->faker->numberBetween(0, 20),
            'status' => $this->faker->randomElement(['draft', 'approved', 'rejected']),
            'parent_id' => null, // Mặc định là comment gốc
            'depth' => 0, // Mặc định là độ sâu 0
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
    
    // Tạo comment con (reply)
    public function reply(): self
    {
        return $this->state(function (array $attributes) {
            $parentComment = Comment::inRandomOrder()->first() ?? 
                            Comment::factory()->create(['parent_id' => null, 'depth' => 0]);
            
            return [
                'parent_id' => $parentComment->comment_id,
                'depth' => $parentComment->depth + 1,
                'article_id' => $parentComment->article_id,
            ];
        });
    }
    
    // Tạo comment đã được phê duyệt
    public function approved(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
            ];
        });
    }
}
