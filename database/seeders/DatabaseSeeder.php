<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
//            DayTableSeeder::class,
//            SettingTableSeeder::class,
//            PermissionsTableSeeder::class,
//            RolesTableSeeder::class,
//            PermissionRoleTableSeeder::class,
//            UsersTableSeeder::class,
//            RoleUserTableSeeder::class,
//            CountryTableSeeder::class,
//            BusinessCategoryTableSeeder::class,
//            ServiceStatusTableSeeder::class,
            GeneralDataSeeders::class,
        ]);
    }
}
