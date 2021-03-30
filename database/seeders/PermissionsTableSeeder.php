<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
//            [
//                'id'    => 1,
//                'title' => 'user_management_access',
//            ],
//            [
//                'id'    => 2,
//                'title' => 'permission_create',
//            ],
//            [
//                'id'    => 3,
//                'title' => 'permission_edit',
//            ],
//            [
//                'id'    => 4,
//                'title' => 'permission_show',
//            ],
//            [
//                'id'    => 5,
//                'title' => 'permission_delete',
//            ],
//            [
//                'id'    => 6,
//                'title' => 'permission_access',
//            ],
//            [
//                'id'    => 7,
//                'title' => 'role_create',
//            ],
//            [
//                'id'    => 8,
//                'title' => 'role_edit',
//            ],
//            [
//                'id'    => 9,
//                'title' => 'role_show',
//            ],
//            [
//                'id'    => 10,
//                'title' => 'role_delete',
//            ],
//            [
//                'id'    => 11,
//                'title' => 'role_access',
//            ],
//            [
//                'id'    => 12,
//                'title' => 'user_create',
//            ],
//            [
//                'id'    => 13,
//                'title' => 'user_edit',
//            ],
//            [
//                'id'    => 14,
//                'title' => 'user_show',
//            ],
//            [
//                'id'    => 15,
//                'title' => 'user_delete',
//            ],
//            [
//                'id'    => 16,
//                'title' => 'user_access',
//            ],
//            [
//                'id'    => 17,
//                'title' => 'profile_password_edit',
//            ],
//            [
//                'id'    => 18,
//                'title' => 'audit_log_show',
//            ],
//            [
//                'id'    => 19,
//                'title' => 'audit_log_access',
//            ],
//
//            [
//                'id'    => 20,
//                'title' => 'country_create',
//            ],
//            [
//                'id'    => 21,
//                'title' => 'country_edit',
//            ],
//            [
//                'id'    => 22,
//                'title' => 'country_show',
//            ],
//            [
//                'id'    => 23,
//                'title' => 'country_delete',
//            ],
//            [
//                'id'    => 24,
//                'title' => 'country_access',
//            ],
//            [
//                'id'    => 25,
//                'title' => 'profile_edit',
//            ],
//            [
//                'id'    => 26,
//                'title' => 'profile_show',
//            ],
//            [
//                'id'    => 27,
//                'title' => 'profile_access',
//            ],
//            [
//                'id'    => 28,
//                'title' => 'setting_edit',
//            ],
//            [
//                'id'    => 29,
//                'title' => 'setting_access',
//            ],

//            [
//                'id'    => 30,
//                'title' => 'business_category_create',
//            ],
//            [
//                'id'    => 31,
//                'title' => 'business_category_edit',
//            ],
//            [
//                'id'    => 32,
//                'title' => 'business_category_show',
//            ],
//            [
//                'id'    => 33,
//                'title' => 'business_category_delete',
//            ],
//            [
//                'id'    => 34,
//                'title' => 'business_category_access',
//            ],
//            [
//                'id'    => 35,
//                'title' => 'business_create',
//            ],
//            [
//                'id'    => 36,
//                'title' => 'business_edit',
//            ],
//            [
//                'id'    => 37,
//                'title' => 'business_show',
//            ],
//            [
//                'id'    => 38,
//                'title' => 'business_delete',
//            ],
//            [
//                'id'    => 39,
//                'title' => 'business_access',
//            ],
//            [
//                'id'    => 40,
//                'title' => 'service_status_create',
//            ],
//            [
//                'id'    => 41,
//                'title' => 'service_status_edit',
//            ],
//            [
//                'id'    => 42,
//                'title' => 'service_status_show',
//            ],
//            [
//                'id'    => 43,
//                'title' => 'service_status_delete',
//            ],
//            [
//                'id'    => 44,
//                'title' => 'service_status_access',
//            ],
//            [
//                'id'    => 45,
//                'title' => 'service_create',
//            ],
//            [
//                'id'    => 46,
//                'title' => 'service_edit',
//            ],
//            [
//                'id'    => 47,
//                'title' => 'service_show',
//            ],
//            [
//                'id'    => 48,
//                'title' => 'service_delete',
//            ],
//            [
//                'id'    => 49,
//                'title' => 'service_access',
//            ],

//            [
//                'id'    => 50,
//                'title' => 'question_create',
//            ],
//            [
//                'id'    => 51,
//                'title' => 'question_edit',
//            ],
//            [
//                'id'    => 52,
//                'title' => 'question_show',
//            ],
//            [
//                'id'    => 53,
//                'title' => 'question_delete',
//            ],
//            [
//                'id'    => 54,
//                'title' => 'question_access',
//            ],
//            [
//                'id'    => 55,
//                'title' => 'answer_create',
//            ],
//            [
//                'id'    => 56,
//                'title' => 'answer_edit',
//            ],
//            [
//                'id'    => 57,
//                'title' => 'answer_show',
//            ],
//            [
//                'id'    => 58,
//                'title' => 'answer_delete',
//            ],
//            [
//                'id'    => 59,
//                'title' => 'answer_access',
//            ],
//            [
//                'id'    => 60,
//                'title' => 'assessment_create',
//            ],
//            [
//                'id'    => 61,
//                'title' => 'assessment_show',
//            ],
//            [
//                'id'    => 62,
//                'title' => 'assessment_delete',
//            ],
//            [
//                'id'    => 63,
//                'title' => 'assessment_access',
//            ],

//            [
//                'id'    => 64,
//                'title' => 'service_history_create',
//            ],
//            [
//                'id'    => 65,
//                'title' => 'service_history_edit',
//            ],
//            [
//                'id'    => 66,
//                'title' => 'service_history_show',
//            ],
//            [
//                'id'    => 67,
//                'title' => 'service_history_delete',
//            ],
//            [
//                'id'    => 68,
//                'title' => 'service_history_access',
//            ],
//            [
//                'id'    => 69,
//                'title' => 'service_assign_to',
//            ],
//            [
//                'id'    => 70,
//                'title' => 'service_history',
//            ],
//            [
//                'id'    => 71,
//                'title' => 'service_message',
//            ],
//            [
//                'id'    => 72,
//                'title' => 'service_status_change',
//            ],
//            [
//                'id'    => 73,
//                'title' => 'service_comments',
//            ],
//
//            [
//                'id'    => 74,
//                'title' => 'training_create',
//            ],
//            [
//                'id'    => 75,
//                'title' => 'training_edit',
//            ],
//            [
//                'id'    => 76,
//                'title' => 'training_show',
//            ],
//            [
//                'id'    => 78,
//                'title' => 'training_delete',
//            ],
//            [
//                'id'    => 79,
//                'title' => 'training_access',
//            ],
//            [
//                'id'    => 80,
//                'title' => 'training_apply',
//            ],
//            [
//                'id'    => 81,
//                'title' => 'training_approved',
//            ],
//            [
//                'id'    => 82,
//                'title' => 'training_apply_create',
//            ],
//            [
//                'id'    => 83,
//                'title' => 'training_apply_edit',
//            ],
//            [
//                'id'    => 84,
//                'title' => 'training_apply_show',
//            ],
//            [
//                'id'    => 85,
//                'title' => 'training_apply_access',
//            ],
            [
                'id'    => 86,
                'title' => 'attendance_create',
            ],
            [
                'id'    => 87,
                'title' => 'attendance_edit',
            ],
            [
                'id'    => 88,
                'title' => 'attendance_show',
            ],
            [
                'id'    => 89,
                'title' => 'attendance_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
