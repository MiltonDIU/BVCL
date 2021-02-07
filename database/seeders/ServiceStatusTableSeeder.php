<?php

namespace Database\Seeders;

use App\Models\ServiceStatus;
use Illuminate\Database\Seeder;

class ServiceStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id'    => 1,
                'name' => 'Pending',
                'slug' => 'pending',
                'message' => 'Your service is currently pending, soon our officer will make a decision about your service',
            ],
            [
                'id'    => 2,
                'name' => 'Canceled',
                'slug' => 'canceled',
                'message' => 'Your service has been canceled',
            ],
            [
                'id'    => 3,
                'name' => 'Processing',
                'slug' => 'processing',
                'message' => 'Your service is being processed',
            ],
        ];

        ServiceStatus::insert($statuses);
    }
}
