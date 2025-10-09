<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('👑 Creating admin users...');

        User::updateOrCreate(
            ['email' => 'admin@collection.com'],
            [
                'name' => 'Collection Admin',
                'email' => 'admin@collection.com',
                'mobile' => '+201234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'u_type' => 'ADM',
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@collection.com'],
            [
                'name' => 'Collection Manager',
                'email' => 'manager@collection.com',
                'mobile' => '+201234567891',
                'email_verified_at' => now(),
                'password' => Hash::make('manager123'),
                'u_type' => 'MGR',
            ]
        );

        $this->command->info('✅ Admin users created successfully!');
    }
}
