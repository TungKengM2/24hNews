<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'ADMIN',
            'phone' => '0356584633',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // Giả sử role_id = 1 là Admin
            'is_promoted' => true,
            'violation_count' => 0,
            'banned_until' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
