<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class RoleSeeder extends Seeder
    {

        /**
         * Run the database seeds.
         */
        public function run(): void
        {

            DB::table('roles')->insert([
                [
                    'name' => 'admin',
                    'description' => 'Administrator',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'article',
                    'description' => 'Article',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'moderator',
                    'description' => 'Moderator',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'user',
                    'description' => 'User',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'guest',
                    'description' => 'Guest',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]);

        }


    }
