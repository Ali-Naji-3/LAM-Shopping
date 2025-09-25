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
        $modules = ['users', 'roles', 'permissions', 'products', 'categories'];


        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = $action . ' ' . $module;


                Permission::firstOrCreate(['name' => $permissionName]);
            }
        }
    }
}
