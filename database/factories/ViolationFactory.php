<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViolationFactory extends Factory
{
    protected $model = Violation::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['article', 'comment', 'user']);
        $referenceId = null;
        
        switch ($type) {
            case 'article':
                $referenceId = Article::inRandomOrder()->first()->article_id ?? 
                              Article::factory()->create()->article_id;
                break;
            case 'comment':
                $referenceId = \App\Models\Comment::inRandomOrder()->first()->comment_id ?? 
                              \App\Models\Comment::factory()->create()->comment_id;
                break;
            case 'user':
                $referenceId = User::inRandomOrder()->first()->user_id ?? 
                              User::factory()->create()->user_id;
                break;
        }
        
        $handledBy = $this->faker->boolean(70) ? 
                    User::where('role_id', 1)->inRandomOrder()->first()->user_id ?? 
                    User::factory()->create(['role_id' => 1])->user_id : null;
        
        $status = $handledBy ? $this->faker->randomElement(['pending', 'resolved']) : 'pending';
        
        $possibleWords = ['fuck', 'shit', 'damn', 'bitch', 'ass', 'hell', 'crap', 'bastard', 'screw', 'jerk'];
        
        return [
            'type' => $type,
            'reference_id' => $referenceId,
            'detected_word' => $this->faker->randomElement($possibleWords),
            'detected_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'handled_by' => $handledBy,
            'status' => $status,
            'warning_sent' => $this->faker->boolean(50), // 50% chance to have warning sent
        ];
    }
    
    // Tạo violation cho bài viết
    public function forArticle(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'article',
                'reference_id' => Article::inRandomOrder()->first()->article_id ?? 
                                 Article::factory()->create()->article_id,
            ];
        });
    }
    
    // Tạo violation cho comment
    public function forComment(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'comment',
                'reference_id' => \App\Models\Comment::inRandomOrder()->first()->comment_id ?? 
                                 \App\Models\Comment::factory()->create()->comment_id,
            ];
        });
    }
    
    // Tạo violation cho user
    public function forUser(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'user',
                'reference_id' => User::inRandomOrder()->first()->user_id ?? 
                                 User::factory()->create()->user_id,
            ];
        });
    }
}
