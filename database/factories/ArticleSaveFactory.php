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
        return [
            'article_id' => Article::where('status', 'published')->inRandomOrder()->first()->article_id ?? 
                           Article::factory()->published()->create()->article_id,
            'user_id' => User::inRandomOrder()->first()->user_id ?? 
                        User::factory()->create()->user_id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
