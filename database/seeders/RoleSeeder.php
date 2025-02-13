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
            ['name' => 'admin', 'description' => 'Admin'],
            ['name' => 'editor', 'description' => 'Biên tập viên'],
            ['name' => 'writer', 'description' => 'Người viết bài'],
            ['name' => 'user', 'description' => 'Người dùng thường'],
        ]);
    }
}
