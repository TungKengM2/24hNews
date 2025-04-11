<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleViewFactory extends Factory
{
    protected $model = \App\Models\ArticleView::class;

    public function definition(): array
    {
        $isAnonymous = $this->faker->boolean(40); // 40% chance to be anonymous
        
        return [
            'anonymous' => $isAnonymous ? $this->faker->uuid() : null,
            'article_id' => Article::where('status', 'published')->inRandomOrder()->first()->article_id ?? 
                           Article::factory()->published()->create()->article_id,
            'user_id' => $isAnonymous ? null : (User::inRandomOrder()->first()->user_id ?? 
                        User::factory()->create()->user_id),
            'viewed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
    
    // Tạo view từ người dùng đã đăng nhập
    public function fromUser(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'anonymous' => null,
                'user_id' => User::inRandomOrder()->first()->user_id ?? 
                            User::factory()->create()->user_id,
            ];
        });
    }
    
    // Tạo view từ người dùng ẩn danh
    public function anonymous(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'anonymous' => $this->faker->uuid(),
                'user_id' => null,
            ];
        });
    }
}
