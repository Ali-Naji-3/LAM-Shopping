<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الموديولات الأساسية اللي بدك تنشئ لها صلاحيات
        $modules = ['users', 'roles', 'permissions', 'products', 'categories'];

        // أنواع الصلاحيات الأساسية
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = $action . ' ' . $module;

                // إذا ما كانت الصلاحية موجودة، أنشئها
                Permission::firstOrCreate(['name' => $permissionName]);
            }
        }
    }
}
