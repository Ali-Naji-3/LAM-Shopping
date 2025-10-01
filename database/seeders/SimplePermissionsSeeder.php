<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SimplePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing permissions and roles
        Permission::truncate();
        Role::truncate();
        
        // Remove all roles from users
        User::all()->each(function($user) {
            $user->roles()->detach();
        });
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create only 2 roles: admin and customer
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);

        // Admin gets all permissions (no need to create individual permissions)
        // Customer gets no permissions (frontend access only)

        // Assign Admin role to admin@collection.com
        $admin = User::where('email', 'admin@collection.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
            $this->command->info('Admin role assigned to admin@collection.com');
        }

        // Assign Customer role to manager@collection.com (for testing)
        $manager = User::where('email', 'manager@collection.com')->first();
        if ($manager) {
            $manager->assignRole('customer');
            $this->command->info('Customer role assigned to manager@collection.com');
        }

        // Assign Customer role to user@collection.com
        $user = User::where('email', 'user@collection.com')->first();
        if ($user) {
            $user->assignRole('customer');
            $this->command->info('Customer role assigned to user@collection.com');
        }

        $this->command->info('Simple 2-role system created successfully!');
        $this->command->info('Total permissions: ' . Permission::count());
        $this->command->info('Available roles: ' . Role::all()->pluck('name')->implode(', '));
        $this->command->info('Roles created: admin, customer');
    }
}
