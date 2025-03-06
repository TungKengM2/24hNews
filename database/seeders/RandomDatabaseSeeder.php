<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Faker\Factory as Faker;
    use Illuminate\Support\Str;

    class RandomDatabaseSeeder extends Seeder
    {

        public function run()
        {
            $tables = [
                'approvals',
                'article_history',
                'article_likes',
                'article_media',
                'article_tags',
                'article_views',
                'articles',
                'categories',
                'comment_reactions',
                'comments',
                'failed_jobs',
                'jobs',
                'migrations',
                'roles',
                'tags',
                'users',

            ];

            $faker = Faker::create();

            // Xóa dữ liệu cũ
            Schema::disableForeignKeyConstraints();
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            Schema::enableForeignKeyConstraints();

            // Seed bảng categories TRƯỚC
            DB::table('categories')->insert([
                [
                    'category_id' => 1,
                    'name' => 'Technology',
                    'slug' => 'technology',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 2,
                    'name' => 'Science',
                    'slug' => 'science',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 3,
                    'name' => 'Health',
                    'slug' => 'health',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 4,
                    'name' => 'Business',
                    'slug' => 'business',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 5,
                    'name' => 'Sports',
                    'slug' => 'sports',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // Seed bảng roles
            DB::table('roles')->insert([
                [
                    'name' => 'admin',
                    'description' => 'Full rules',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'author',
                    'description' => 'crud articles',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'moderator',
                    'description' => 'review articles and comments',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'user',
                    'description' => 'read articles and comments...',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // Seed bảng users
            for ($i = 0; $i < 10; $i++) {
                DB::table('users')->insert($this->generateFakeData('users',
                    $faker));
            }

            // Seed bảng articles
            for ($i = 0; $i < 100; $i++) {
                DB::table('articles')
                    ->insert($this->generateFakeData('articles', $faker));
            }

            // Seed các bảng khác
            foreach ($tables as $table) {
                if (!in_array($table,
                    ['roles', 'users', 'articles', 'categories'])) {
                    for ($i = 0; $i < 10; $i++) {
                        DB::table($table)
                            ->insert($this->generateFakeData($table, $faker));
                    }
                }
            }
        }

        private function generateFakeData($table, $faker)
        {
            $data = [];
            switch ($table) {
                case 'users':
                    $data = [
                        'username' => $faker->userName,
                        'phone' => substr($faker->phoneNumber, 0, 15),
                        // Giới hạn độ dài tối đa 15 ký tự
                        'image' => $faker->imageUrl(),
                        'email' => $faker->unique()->safeEmail,
                        'email_verified_at' => now(),
                        'password' => bcrypt('password'),
                        'remember_token' => $faker->sha256,
                        'role_id' => rand(1, 4),
                        'is_promoted' => rand(0, 1),
                        'violation_count' => rand(0, 10),
                        'banned_until' => null,
                    ];
                    break;

                case 'articles':
                    $authorId = DB::table('users')
                        ->inRandomOrder()
                        ->value('user_id') ?? 1;
                    $data = [
                        'title' => $faker->sentence,
                        'slug' => $faker->slug,
                        'content' => $faker->paragraph,
                        'preview_content' => $faker->text(200),
                        'contains_sensitive_content' => rand(0, 1),
                        'author_id' => $authorId,
                        'category_id' => rand(1, 5),
                        'thumbnail_url' => $faker->imageUrl(),
                        'status' => $faker->randomElement([
                            'draft',
                            'published',
                            'archived',
                        ]),
                        'views' => rand(0, 1000),
                        'approved_by' => rand(1, 10),
                    ];
                    break;
                case 'comments':
                    $articleId = DB::table('articles')
                        ->inRandomOrder()
                        ->value('article_id') ?? 1;
                    $data = [
                        'article_id' => $articleId,
                        'user_id' => rand(1, 10),
                        'content' => $faker->sentence,
                        'likes' => rand(0, 100),
                        'dislikes' => rand(0, 50),
                        'status' => $faker->randomElement([
                            'approved',

                            'rejected',
                        ]),
                        'parent_id' => null,
                        'depth' => rand(0, 5),
                    ];
                    break;
                case 'approvals':
                    $articleId = DB::table('articles')
                        ->inRandomOrder()
                        ->value('article_id') ?? 1;
                    $data = [
                        'article_id' => $articleId,
                        'approved_by' => rand(1, 10),
                        'status' => $faker->randomElement([
                            'approved',
                            'rejected',
                            'pending',
                        ]),
                    ];
                    break;
                case 'violations':
                    $data = [
                        'user_id' => rand(1, 10),
                        'reason' => $faker->sentence,
                        'resolved' => rand(0, 1),
                    ];
                    break;
                case 'articles':
                    $authorId = DB::table('users')
                        ->inRandomOrder()
                        ->value('user_id') ?? 1;
                    $categoryId = DB::table('categories')
                        ->inRandomOrder()
                        ->value('category_id') ?? 1;

                    $data = [
                        'title' => $faker->sentence,
                        'slug' => $faker->slug,
                        'content' => $faker->paragraph,
                        'preview_content' => $faker->text(200),
                        'contains_sensitive_content' => rand(0, 1),
                        'author_id' => $authorId,
                        'category_id' => $categoryId, // Chọn category_id hợp lệ
                        'thumbnail_url' => $faker->imageUrl(),
                        'status' => $faker->randomElement([
                            'draft',
                            'published',
                            'archived',
                        ]),
                        'views' => rand(0, 1000),
                        'approved_by' => rand(1, 10),
                    ];
                    break;

                case 'article_media':
                    $articleId = DB::table('articles')
                        ->inRandomOrder()
                        ->value('article_id') ?? 1;
                    $data = [
                        'article_id' => $articleId,
                        'media_url' => $faker->imageUrl(),
                        'media_type' => $faker->randomElement([
                            'image',
                            'video',
                        ]),
                        'position' => rand(1, 10), // Thêm giá trị cho position
                    ];
                    break;
                case 'jobs':
                    $data = [
                        'queue' => 'default',
                        'payload' => json_encode([
                            'job' => 'ExampleJob',
                            'data' => [],
                        ]),
                        'attempts' => 0,
                        'available_at' => now(), // Sử dụng Carbon instance
                    ];

                    // Kiểm tra xem bảng có cột 'created_at' không
                    $columns = Schema::getColumnListing($table);
                    if (in_array('created_at', $columns)) {
                        $data['created_at'] = now(); // Sử dụng Carbon instance cho bảng jobs
                    }

                    // Kiểm tra xem bảng có cột 'updated_at' không
                    if (in_array('updated_at', $columns)) {
                        $data['updated_at'] = now(); // Sử dụng Carbon instance cho updated_at
                    }
                    break;
            }

            // Thêm created_at và updated_at nếu bảng có cột này
            $columns = Schema::getColumnListing($table);
            if (in_array('created_at', $columns)) {
                $data['created_at'] = now();
            }
            if (in_array('updated_at', $columns)) {
                $data['updated_at'] = now();
            }

            return $data;
        }

    }
