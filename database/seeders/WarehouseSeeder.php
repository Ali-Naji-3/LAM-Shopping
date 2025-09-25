<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Clear existing warehouses (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Warehouse::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $warehouses = [
            [
                'name' => 'Main Distribution Center',
                'code' => 'MDC001',
                'location' => 'New York, NY',
                'manager' => 'John Smith',
                'contact_number' => '+1-555-0101',
                'is_active' => true,
            ],
            [
                'name' => 'West Coast Warehouse',
                'code' => 'WCW002',
                'location' => 'Los Angeles, CA',
                'manager' => 'Sarah Johnson',
                'contact_number' => '+1-555-0102',
                'is_active' => true,
            ],
            [
                'name' => 'Central Hub',
                'code' => 'CHB003',
                'location' => 'Chicago, IL',
                'manager' => 'Michael Brown',
                'contact_number' => '+1-555-0103',
                'is_active' => true,
            ],
            [
                'name' => 'Southeast Facility',
                'code' => 'SEF004',
                'location' => 'Atlanta, GA',
                'manager' => 'Emily Davis',
                'contact_number' => '+1-555-0104',
                'is_active' => true,
            ],
            [
                'name' => 'Texas Distribution',
                'code' => 'TXD005',
                'location' => 'Dallas, TX',
                'manager' => 'Robert Wilson',
                'contact_number' => '+1-555-0105',
                'is_active' => true,
            ],
            [
                'name' => 'Northwest Storage',
                'code' => 'NWS006',
                'location' => 'Seattle, WA',
                'manager' => 'Lisa Anderson',
                'contact_number' => '+1-555-0106',
                'is_active' => true,
            ],
            [
                'name' => 'Florida Warehouse',
                'code' => 'FLW007',
                'location' => 'Miami, FL',
                'manager' => 'David Martinez',
                'contact_number' => '+1-555-0107',
                'is_active' => true,
            ],
            [
                'name' => 'Mountain Region Hub',
                'code' => 'MRH008',
                'location' => 'Denver, CO',
                'manager' => 'Jennifer Taylor',
                'contact_number' => '+1-555-0108',
                'is_active' => true,
            ],
            [
                'name' => 'Northeast Facility',
                'code' => 'NEF009',
                'location' => 'Boston, MA',
                'manager' => 'Christopher Lee',
                'contact_number' => '+1-555-0109',
                'is_active' => true,
            ],
            [
                'name' => 'Southwest Distribution',
                'code' => 'SWD010',
                'location' => 'Phoenix, AZ',
                'manager' => 'Amanda White',
                'contact_number' => '+1-555-0110',
                'is_active' => true,
            ],
            [
                'name' => 'Midwest Storage',
                'code' => 'MWS011',
                'location' => 'Detroit, MI',
                'manager' => 'James Garcia',
                'contact_number' => '+1-555-0111',
                'is_active' => true,
            ],
            [
                'name' => 'Pacific Coast Warehouse',
                'code' => 'PCW012',
                'location' => 'San Francisco, CA',
                'manager' => 'Maria Rodriguez',
                'contact_number' => '+1-555-0112',
                'is_active' => true,
            ],
            [
                'name' => 'Legacy Facility (Inactive)',
                'code' => 'LGF013',
                'location' => 'Philadelphia, PA',
                'manager' => null,
                'contact_number' => null,
                'is_active' => false,
            ],
            [
                'name' => 'Temporary Storage',
                'code' => 'TMP014',
                'location' => 'Las Vegas, NV',
                'manager' => 'Kevin Thompson',
                'contact_number' => '+1-555-0114',
                'is_active' => false,
            ],
            [
                'name' => 'International Gateway',
                'code' => 'IGW015',
                'location' => 'Port of Long Beach, CA',
                'manager' => 'Susan Clark',
                'contact_number' => '+1-555-0115',
                'is_active' => true,
            ],
        ];

        foreach ($warehouses as $warehouseData) {
            Warehouse::create([
                'name' => $warehouseData['name'],
                'code' => $warehouseData['code'],
                'location' => $warehouseData['location'],
                'manager' => $warehouseData['manager'],
                'contact_number' => $warehouseData['contact_number'],
                'is_active' => $warehouseData['is_active'],
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info('Warehouses seeded successfully!');
        $this->command->info('Created ' . count($warehouses) . ' warehouses across multiple locations.');
        $this->command->info('Active warehouses: ' . collect($warehouses)->where('is_active', true)->count());
        $this->command->info('Inactive warehouses: ' . collect($warehouses)->where('is_active', false)->count());
    }
}