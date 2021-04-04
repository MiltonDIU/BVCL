<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            [
                'id' => 1,
                'site_title' => 'Training Management',
                'meta_description' => 'Training Management',
                'meta_keywords' => 'Training Management',
                'site_email' => 'milton2913@gmail.com',
                'site_phone_number' => '01674797580',
                'address' => 'Dhanmondi, Dhaka-1207',
                'google_analytics' => 'Training Management',
                'maintenance_mode' => 'No',
                'maintenance_mode_title' => 'Back',
                'maintenance_mode_content' => '',
                'copyright' => 'DIU',
                'summary' => 'DIU',
                'about' => 'DIU',
            ],
        ];

        Setting::insert($setting);

    }
}
