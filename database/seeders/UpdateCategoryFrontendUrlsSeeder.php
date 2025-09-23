<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class UpdateCategoryFrontendUrlsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔗 Updating category frontend URLs...');
        
        // Update Men category
        $men = Category::where('slug', 'men')->first();
        if ($men) {
            $men->update([
                'frontend_page_url' => 'listing-grid-1-full',
                'is_root_category' => true
            ]);
            $this->command->info('✅ Updated Men category');
        }
        
        // Update Women category
        $women = Category::where('slug', 'women')->first();
        if ($women) {
            $women->update([
                'frontend_page_url' => 'listing-grid-2-full',
                'is_root_category' => true
            ]);
            $this->command->info('✅ Updated Women category');
        }
        
        // Update Boys category
        $boys = Category::where('slug', 'boys')->first();
        if ($boys) {
            $boys->update([
                'frontend_page_url' => 'listing-grid-3-full',
                'is_root_category' => true
            ]);
            $this->command->info('✅ Updated Boys category');
        }
        
        // Update Girls category
        $girls = Category::where('slug', 'girls')->first();
        if ($girls) {
            $girls->update([
                'frontend_page_url' => 'listing-grid-4-full',
                'is_root_category' => true
            ]);
            $this->command->info('✅ Updated Girls category');
        }
        
        // Update Collections category
        $collections = Category::where('slug', 'collections')->first();
        if ($collections) {
            $collections->update([
                'frontend_page_url' => 'collections',
                'is_root_category' => true
            ]);
            $this->command->info('✅ Updated Collections category');
        }
        
        $this->command->info('🎉 Frontend URLs updated successfully!');
    }
}