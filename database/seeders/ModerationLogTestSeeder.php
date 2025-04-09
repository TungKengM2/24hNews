<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModerationLogTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CommentModerationLogSeeder::class,
            RoleUpgradeModerationLogSeeder::class,
        ]);
    }
}
