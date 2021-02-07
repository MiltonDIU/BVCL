<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use Illuminate\Database\Seeder;

class BusinessCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'IT & ITES',
                'short_name'          => 'it-ites',
                'is_active'           => 1,
            ],
            [
                'id'             => 2,
                'name'           => 'Edutech',
                'short_name'          => 'edutech',
                'is_active'           => 1,
            ],
            [
                'id'             => 3,
                'name'           => 'Health Tech',
                'short_name'          => 'health-tech',
                'is_active'           => 1,
            ],
            [
                'id'             => 4,
                'name'           => 'Fintech AI & ML',
                'short_name'          => 'fintech-ai-ml',
                'is_active'           => 1,
            ],
            [
                'id'             => 5,
                'name'           => 'Block chain',
                'short_name'          => 'block-chain',
                'is_active'           => 1,
            ],
            [
                'id'             => 6,
                'name'           => 'Big Data and Data Analysis',
                'short_name'          => 'big-data',
                'is_active'           => 1,
            ],
            [
                'id'             => 7,
                'name'           => 'AR and VR',
                'short_name'          => 'ar',
                'is_active'           => 1,
            ],
            [
                'id'             => 8,
                'name'           => 'Agritech, Biotech and Food Processing',
                'short_name'          => 'abfp',
                'is_active'           => 1,
            ],
            [
                'id'             => 9,
                'name'           => 'Others',
                'short_name'          => 'others',
                'is_active'           => 1,
            ],
        ];

        BusinessCategory::insert($users);
    }
}
