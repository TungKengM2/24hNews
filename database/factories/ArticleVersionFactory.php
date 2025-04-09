<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleVersionFactory extends Factory
{
    protected $model = ArticleVersion::class;

    public function definition(): array
    {
        $article = Article::inRandomOrder()->first() ?? Article::factory()->create();

        // Tạo version_id duy nhất bằng cách thêm timestamp
        $uniqueId = uniqid();
        $versionId = $article->code . '-v' . $uniqueId;

        // Kiểm tra xem version_id đã tồn tại chưa
        while (ArticleVersion::where('version_id', $versionId)->exists()) {
            $uniqueId = uniqid();
            $versionId = $article->code . '-v' . $uniqueId;
        }

        $title = $this->faker->sentence();
        $content = '<p>' . implode('</p><p>', $this->faker->paragraphs(rand(5, 15))) . '</p>';

        $tags = [];
        $tagCount = rand(2, 5);
        for ($i = 0; $i < $tagCount; $i++) {
            $tags[] = $this->faker->word();
        }

        return [
            'version_id' => $versionId,
            'article_id' => $article->article_id,
            'user_id' => $article->author_id ?? User::where('role_id', 2)->inRandomOrder()->first()->user_id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $content,
            'category_id' => $article->category_id ?? Category::inRandomOrder()->first()->category_id,
            'featured_image' => $article->thumbnail_url ?? 'thumbnails/' . $this->faker->image('public/storage/thumbnails', 1200, 630, null, false),
            'tags' => $tags,
            'change_reason' => $this->faker->randomElement([
                'Cập nhật nội dung',
                'Sửa lỗi chính tả',
                'Thêm thông tin mới',
                'Cập nhật hình ảnh',
                'Tạo bài viết mới'
            ]),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
