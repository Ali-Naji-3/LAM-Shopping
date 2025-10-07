<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create comprehensive permissions for all modules
        $modules = [
            'users', 'roles', 'permissions', 'products', 'categories', 
            'brands', 'attributes', 'attribute_values', 'product_attributes',
            'reviews', 'sliders', 'orders', 'order_items', 'warehouses', 
            'inventory', 'transactions', 'contacts', 'contact_responses',
            'dashboard', 'settings', 'analytics', 'reports'
        ];

        $actions = ['view', 'create', 'edit', 'delete', 'manage'];

        $permissions = [];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = $action . ' ' . $module;
                $permissions[] = Permission::firstOrCreate(['name' => $permissionName]);
            }
        }

        // Create Super Admin Role with ALL permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create Admin Role with most permissions (except user management)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminPermissions = [
            'view dashboard', 'view analytics', 'view reports',
            'view products', 'create products', 'edit products', 'delete products', 'manage products',
            'view categories', 'create categories', 'edit categories', 'delete categories', 'manage categories',
            'view brands', 'create brands', 'edit brands', 'delete brands', 'manage brands',
            'view attributes', 'create attributes', 'edit attributes', 'delete attributes', 'manage attributes',
            'view attribute_values', 'create attribute_values', 'edit attribute_values', 'delete attribute_values', 'manage attribute_values',
            'view product_attributes', 'create product_attributes', 'edit product_attributes', 'delete product_attributes', 'manage product_attributes',
            'view reviews', 'create reviews', 'edit reviews', 'delete reviews', 'manage reviews',
            'view sliders', 'create sliders', 'edit sliders', 'delete sliders', 'manage sliders',
            'view orders', 'create orders', 'edit orders', 'delete orders', 'manage orders',
            'view order_items', 'create order_items', 'edit order_items', 'delete order_items', 'manage order_items',
            'view warehouses', 'create warehouses', 'edit warehouses', 'delete warehouses', 'manage warehouses',
            'view inventory', 'create inventory', 'edit inventory', 'delete inventory', 'manage inventory',
            'view transactions', 'create transactions', 'edit transactions', 'delete transactions', 'manage transactions',
            'view contacts', 'create contacts', 'edit contacts', 'delete contacts', 'manage contacts',
            'view contact_responses', 'create contact_responses', 'edit contact_responses', 'delete contact_responses', 'manage contact_responses',
            'view settings'
        ];
        $adminRole->givePermissionTo($adminPermissions);

        // Create Manager Role with limited permissions
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerPermissions = [
            'view dashboard', 'view analytics',
            'view products', 'create products', 'edit products',
            'view categories', 'create categories', 'edit categories',
            'view brands', 'create brands', 'edit brands',
            'view reviews', 'edit reviews',
            'view orders', 'edit orders',
            'view warehouses', 'view inventory',
            'view transactions'
        ];
        $managerRole->givePermissionTo($managerPermissions);

        // Create Editor Role
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorPermissions = [
            'view dashboard',
            'view products', 'create products', 'edit products',
            'view categories', 'create categories', 'edit categories',
            'view brands', 'create brands', 'edit brands',
            'view reviews', 'edit reviews',
            'view sliders', 'create sliders', 'edit sliders'
        ];
        $editorRole->givePermissionTo($editorPermissions);

        // Create Viewer Role (read-only)
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);
        $viewerPermissions = [
            'view dashboard', 'view analytics',
            'view products', 'view categories', 'view brands',
            'view reviews', 'view orders', 'view warehouses',
            'view inventory', 'view transactions'
        ];
        $viewerRole->givePermissionTo($viewerPermissions);

        // Assign Super Admin role to admin@collection.com
        $admin = User::where('email', 'admin@collection.com')->first();
        if ($admin) {
            $admin->assignRole('superadmin');
            $this->command->info('Super Admin role assigned to admin@collection.com');
        }

        // Assign Admin role to manager@collection.com
        $manager = User::where('email', 'manager@collection.com')->first();
        if ($manager) {
            $manager->assignRole('admin');
            $this->command->info('Admin role assigned to manager@collection.com');
        }

        $this->command->info('Admin permissions and roles created successfully!');
        $this->command->info('Available roles: ' . Role::all()->pluck('name')->implode(', '));
        $this->command->info('Total permissions created: ' . Permission::count());
    }
}






