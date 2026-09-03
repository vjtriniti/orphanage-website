<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            ['name'=>'dashboard.view','label'=>'View dashboard'],
            ['name'=>'donations.view','label'=>'View donations'], ['name'=>'donations.manage','label'=>'Manage donations'],
            ['name'=>'children.view','label'=>'View children'], ['name'=>'children.manage','label'=>'Manage children'],
            ['name'=>'campaigns.manage','label'=>'Manage campaigns'], ['name'=>'expenses.manage','label'=>'Manage expenses'],
            ['name'=>'volunteers.view','label'=>'View volunteers'], ['name'=>'volunteers.manage','label'=>'Manage volunteers'],
            ['name'=>'inventory.view','label'=>'View inventory'], ['name'=>'inventory.manage','label'=>'Manage inventory'],
            ['name'=>'events.manage','label'=>'Manage events'], ['name'=>'education.view','label'=>'View education'], ['name'=>'education.manage','label'=>'Manage education'],
            ['name'=>'healthcare.view','label'=>'View healthcare'], ['name'=>'healthcare.manage','label'=>'Manage healthcare'],
            ['name'=>'content.manage','label'=>'Manage content'], ['name'=>'gallery.view','label'=>'View gallery'], ['name'=>'gallery.manage','label'=>'Manage gallery'],
            ['name'=>'messages.view','label'=>'View messages'], ['name'=>'messages.manage','label'=>'Manage messages'],
            ['name'=>'newsletter.view','label'=>'View newsletter'], ['name'=>'newsletter.manage','label'=>'Manage newsletter'],
            ['name'=>'notifications.view','label'=>'View notifications'], ['name'=>'notifications.manage','label'=>'Manage notifications'],
            ['name'=>'reports.view','label'=>'View reports'], ['name'=>'reports.export','label'=>'Export reports'],
            ['name'=>'audit.view','label'=>'View audit logs'], ['name'=>'settings.manage','label'=>'Manage settings'], ['name'=>'roles.manage','label'=>'Manage roles'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(['name'=>$permission['name']], array_merge($permission, ['updated_at'=>now(), 'created_at'=>now()]));
        }

        foreach ([
            ['name'=>'super-admin','label'=>'Super Admin'],
            ['name'=>'operations-manager','label'=>'Operations Manager'],
            ['name'=>'finance-manager','label'=>'Finance Manager'],
            ['name'=>'volunteer-coordinator','label'=>'Volunteer Coordinator'],
            ['name'=>'content-manager','label'=>'Content Manager'],
        ] as $role) {
            DB::table('roles')->updateOrInsert(['name'=>$role['name']], array_merge($role, ['updated_at'=>now(), 'created_at'=>now()]));
        }

        $allPermissions = DB::table('permissions')->pluck('id','name');
        $roleIds = DB::table('roles')->pluck('id','name');
        $rolePermissions = [
            'super-admin' => array_keys($allPermissions->toArray()),
            'operations-manager' => ['dashboard.view','children.view','children.manage','campaigns.manage','volunteers.view','volunteers.manage','inventory.view','inventory.manage','events.manage','education.view','education.manage','healthcare.view','healthcare.manage','gallery.view','gallery.manage','messages.view','notifications.view'],
            'finance-manager' => ['dashboard.view','donations.view','donations.manage','expenses.manage','reports.view','reports.export'],
            'volunteer-coordinator' => ['dashboard.view','volunteers.view','volunteers.manage','events.manage','notifications.view'],
            'content-manager' => ['dashboard.view','content.manage','gallery.view','gallery.manage','messages.view','newsletter.view','newsletter.manage'],
        ];

        foreach ($rolePermissions as $role => $names) {
            foreach ($names as $name) {
                if (isset($roleIds[$role], $allPermissions[$name])) {
                    DB::table('permission_role')->updateOrInsert(['role_id'=>$roleIds[$role], 'permission_id'=>$allPermissions[$name]]);
                }
            }
        }
    }

    public function down(): void
    {
        DB::table('permission_role')->delete();
        DB::table('role_user')->delete();
        DB::table('roles')->whereIn('name',['super-admin','operations-manager','finance-manager','volunteer-coordinator','content-manager'])->delete();
        DB::table('permissions')->delete();
    }
};
