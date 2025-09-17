<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@collection.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@collection.com',
                'mobile' => '1234567890',
                'password' => Hash::make('password123'),
                'u_type' => 'ADM',
                'email_verified_at' => now(),
            ]
        );

        // Create Manager User
        User::updateOrCreate(
            ['email' => 'manager@collection.com'],
            [
                'name' => 'Manager User',
                'email' => 'manager@collection.com',
                'mobile' => '0987654321',
                'password' => Hash::make('password123'),
                'u_type' => 'MGR',
                'email_verified_at' => now(),
            ]
        );

        // Create Regular User
        User::updateOrCreate(
            ['email' => 'user@collection.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@collection.com',
                'mobile' => '1122334455',
                'password' => Hash::make('password123'),
                'u_type' => 'USR',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('Admin: admin@collection.com / password123');
        $this->command->info('Manager: manager@collection.com / password123');
        $this->command->info('User: user@collection.com / password123');
    }
}
