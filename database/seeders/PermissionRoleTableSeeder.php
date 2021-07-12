<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        $admin_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($admin_permissions);

        $teacher_permissions = $admin_permissions->whereIn('title', [
            'attendance_create', 'profile_password_edit', 'profile_show','profile_edit'
        ]);
        Role::findOrFail(3)->permissions()->sync($teacher_permissions);

        $student_permissions = $admin_permissions->whereIn('title', [
            'training_access', 'training_show', 'training_apply','profile_edit', 'service_comments','service_message','service_history','service_history_access','service_history_show','service_history_create','assessment_show','assessment_access', 'assessment_create', 'assessment_show','service_access','service_show','service_create','business_access','business_show','business_edit','business_create'
        ]);
        Role::findOrFail(4)->permissions()->sync($student_permissions);

        $special_permissions = $admin_permissions->whereIn('title', [
            'audit_log_show', 'audit_log_access','profile_password_edit', 'profile_show','profile_edit'
        ]);
        Role::findOrFail(5)->permissions()->sync($special_permissions);
    }
}
