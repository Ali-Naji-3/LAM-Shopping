<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RealDataSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user first
        $this->command->info('👑 Creating admin user...');

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

        // Run the real data seeder
     $this->call([
    BrandSeeder::class,
    CategorySeeder::class,
    ProductSeeder::class,
    ReviewSeeder::class,
]);
        $this->command->info('🎉 Database seeded with REAL data successfully!');
        $this->command->info('🔑 Admin Login: admin@collection.com / admin123');
        $this->command->info('🔑 Manager Login: manager@collection.com / manager123');
    }
}
