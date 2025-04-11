<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        // Đảm bảo tạo tên danh mục hoàn toàn duy nhất
        $name = $this->faker->unique()->words(rand(1, 3), true) . ' ' . uniqid();
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'is_active' => $this->faker->boolean(80), // 80% chance to be active
            'moderator_id' => function () {
                // Lấy moderator ngẫu nhiên (role_id = 3)
                return User::where('role_id', 3)->inRandomOrder()->first()->user_id ??
                       User::factory()->create(['role_id' => 3])->user_id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
