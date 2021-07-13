<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = Permission::all();
        $super_admin = $permissions->whereNotIn('title', [
            'training_apply'
        ]);

        Role::findOrFail(1)->permissions()->sync($super_admin->pluck('id'));

        $admin_permissions = $permissions->filter(function ($permission) {
            return substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($admin_permissions);

        $teacher_permissions = $permissions->whereIn('title', [
            'training_show','training_access','attendance_create', 'profile_password_edit', 'profile_show','profile_edit','attendance_edit','attendance_show','attendance_access'
        ]);
        Role::findOrFail(3)->permissions()->sync($teacher_permissions);

        $student_permissions = $permissions->whereIn('title', [
            'training_access', 'training_show', 'training_apply','profile_edit', 'service_comments','service_message','service_history','service_history_access','service_history_show','service_history_create','assessment_show','assessment_access', 'assessment_create', 'assessment_show','service_access','service_show','service_create','business_access','business_show','business_edit','business_create'
        ]);
        Role::findOrFail(4)->permissions()->sync($student_permissions);

        $special_permissions = $permissions->whereIn('title', [
            'audit_log_show', 'audit_log_access','profile_password_edit', 'profile_show','profile_edit'
        ]);
        Role::findOrFail(5)->permissions()->sync($special_permissions);
    }
}
