<?php

namespace Database\Factories;

use App\Models\Approval;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApprovalFactory extends Factory
{
    protected $model = Approval::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['article', 'role_upgrade']);
        $articleId = null;
        
        if ($type === 'article') {
            $articleId = Article::where('status', 'pending')->inRandomOrder()->first()->article_id ?? 
                        Article::factory()->pending()->create()->article_id;
        }
        
        $userId = User::inRandomOrder()->first()->user_id ?? 
                 User::factory()->create()->user_id;
        
        $approvedBy = null;
        $status = $this->faker->randomElement(['pending', 'approved', 'rejected']);
        
        if ($status !== 'pending') {
            $approvedBy = User::where('role_id', 1)->inRandomOrder()->first()->user_id ?? 
                         User::factory()->create(['role_id' => 1])->user_id;
        }
        
        $violationLevel = $this->faker->randomElement(['none', 'low', 'medium', 'high']);
        $violations = [];
        $violationDetails = [];
        
        if ($violationLevel !== 'none') {
            $possibleViolations = ['nudity', 'violence', 'hate_speech', 'harassment', 'spam', 'misinformation'];
            $violations = $this->faker->randomElements($possibleViolations, rand(1, 3));
            
            foreach ($violations as $violation) {
                $violationDetails[$violation] = $this->faker->sentence();
            }
        }
        
        return [
            'type' => $type,
            'article_id' => $articleId,
            'user_id' => $userId,
            'approved_by' => $approvedBy,
            'requested_role' => $type === 'role_upgrade' ? $this->faker->randomElement(['author', 'moderator']) : null,
            'status' => $status,
            'auto_reviewed' => $this->faker->boolean(30), // 30% chance to be auto-reviewed
            'remarks' => $this->faker->paragraph(),
            'violation_level' => $violationLevel,
            'violations' => !empty($violations) ? json_encode($violations) : null,
            'violation_details' => !empty($violationDetails) ? json_encode($violationDetails) : null,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
    
    // Tạo approval cho bài viết
    public function forArticle(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'article',
                'article_id' => Article::where('status', 'pending')->inRandomOrder()->first()->article_id ?? 
                               Article::factory()->pending()->create()->article_id,
                'requested_role' => null,
            ];
        });
    }
    
    // Tạo approval cho nâng cấp vai trò
    public function forRoleUpgrade(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'role_upgrade',
                'article_id' => null,
                'requested_role' => $this->faker->randomElement(['author', 'moderator']),
            ];
        });
    }
}
