<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // Chạy RoleSeeder trước
            UserSeeder::class, // Sau đó mới chạy UserSeeder
        ]);

        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
