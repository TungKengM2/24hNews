<?php

namespace Database\Seeders;

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

            //            [
            //                'name' => 'guest',
            //                'description' => 'Guest',
            //                'created_at' => now(),
            //                'updated_at' => now(),
            //            ],

        ]);
    }
}
