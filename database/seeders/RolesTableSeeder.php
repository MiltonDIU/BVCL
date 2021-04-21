<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Super Admin',
            ],
            [
                'id'    => 2,
                'title' => 'Admin',
            ],
            [
                'id'    => 3,
                'title' => 'Teacher',
            ],
            [
                'id'    => 4,
                'title' => 'Student',
            ],
            [
                'id'    => 5,
                'title' => 'Instructor',
            ],
            [
                'id'    => 6,
                'title' => 'Special',
            ],
        ];

        Role::insert($roles);
    }
}
