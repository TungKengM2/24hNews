<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
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
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
