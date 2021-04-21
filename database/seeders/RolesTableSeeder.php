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
                'title' => 'Student',
            ],
            [
                'id'    => 3,
                'title' => 'Admin',
            ],
            [
                'id'    => 4,
                'title' => 'Teacher',
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
