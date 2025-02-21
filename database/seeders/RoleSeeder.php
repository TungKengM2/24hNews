<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\File;
    use App\Models\Role;

    class RoleSeeder extends Seeder
    {

        public function run()
        {
            $roles = [
                ['name' => 'admin', 'description' => 'Full rules'],
                ['name' => 'author', 'description' => 'CRUD articles'],
                [
                    'name' => 'moderator',
                    'description' => 'Review articles and comments',
                ],
                [
                    'name' => 'user',
                    'description' => 'Read articles and comments',
                ],
            ];

            foreach ($roles as $role) {
                Role::updateOrCreate(['name' => $role['name']], $role);
            }

            $roles = Role::pluck('role_id', 'name')->toArray();
            $content = '<?php' . PHP_EOL . 'return ' . var_export($roles,
                    true) . ';';
            File::put(config_path('roles.php'), $content);
        }

    }
