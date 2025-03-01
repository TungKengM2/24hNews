<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'ADMIN',
                'phone' => '0356584633',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // Admin
                'is_promoted' => true,
                'violation_count' => 0,
                'banned_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Kiểm Duyệt',
                'phone' => '012345678',
                'email' => 'kdv@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'is_promoted' => true,
                'violation_count' => 0,
                'banned_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Tác Giả',
                'phone' => '0912345678',
                'email' => 'tacgia@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'is_promoted' => false,
                'violation_count' => 1,
                'banned_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'User',
                'phone' => '0923456789',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'is_promoted' => false,
                'violation_count' => 0,
                'banned_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
