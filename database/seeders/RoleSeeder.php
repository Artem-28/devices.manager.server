<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'title' => 'Админ',
                'slug' => Role::ADMIN,
                'description' => 'Имеет полный доступ к функциям приложению',
                'active' => true,
            ],
            [
                'title' => 'Оператор',
                'slug' => Role::OPERATOR,
                'description' => 'Имеет ограниченный доступ к функциям приложения',
                'active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate([
                'slug' => $role['slug'],
            ], $role);
        }
    }
}
