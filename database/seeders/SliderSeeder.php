<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing sliders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Slider::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sliders = [
            [
                'title' => 'Summer Sale 2025',
                'subtitle' => 'Up to 70% off on all summer collections. Limited time offer!',
                'image' => 'sliders/summer-sale-2025.jpg',
                'link' => 'https://example.com/summer-sale',
                'button_text' => 'Shop Now',
                'is_active' => true,
                'order' => 1,
                'start_date' => now()->subDays(5)->toDateString(),
                'end_date' => now()->addDays(25)->toDateString(),
            ],
            [
                'title' => 'New Arrivals',
                'subtitle' => 'Discover the latest trends and styles in our new collection',
                'image' => 'sliders/new-arrivals.jpg',
                'link' => 'https://example.com/new-arrivals',
                'button_text' => 'Explore',
                'is_active' => true,
                'order' => 2,
                'start_date' => null,
                'end_date' => null,
            ],
            [
                'title' => 'Free Shipping',
                'subtitle' => 'Free shipping on orders over $50. No code needed!',
                'image' => 'sliders/free-shipping.jpg',
                'link' => 'https://example.com/shipping-info',
                'button_text' => 'Learn More',
                'is_active' => true,
                'order' => 3,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(60)->toDateString(),
            ],
            [
                'title' => 'Premium Collection',
                'subtitle' => 'Luxury items crafted with the finest materials',
                'image' => 'sliders/premium-collection.jpg',
                'link' => 'https://example.com/premium',
                'button_text' => 'View Collection',
                'is_active' => false,
                'order' => 4,
                'start_date' => null,
                'end_date' => null,
            ],
            [
                'title' => 'Black Friday Preview',
                'subtitle' => 'Get ready for our biggest sale of the year!',
                'image' => 'sliders/black-friday-preview.jpg',
                'link' => 'https://example.com/black-friday',
                'button_text' => 'Notify Me',
                'is_active' => false,
                'order' => 5,
                'start_date' => now()->addDays(30)->toDateString(),
                'end_date' => now()->addDays(37)->toDateString(),
            ],
            [
                'title' => 'Customer Reviews',
                'subtitle' => 'See what our customers are saying about our products',
                'image' => 'sliders/customer-reviews.jpg',
                'link' => 'https://example.com/reviews',
                'button_text' => 'Read Reviews',
                'is_active' => true,
                'order' => 6,
                'start_date' => null,
                'end_date' => null,
            ],
            [
                'title' => 'Winter Clearance',
                'subtitle' => 'Last chance to grab winter items at amazing prices',
                'image' => 'sliders/winter-clearance.jpg',
                'link' => 'https://example.com/clearance',
                'button_text' => 'Shop Clearance',
                'is_active' => false,
                'order' => 7,
                'start_date' => now()->subDays(30)->toDateString(),
                'end_date' => now()->subDays(1)->toDateString(), // Expired
            ],
            [
                'title' => 'Mobile App Launch',
                'subtitle' => 'Download our new mobile app and get 20% off your first order',
                'image' => 'sliders/mobile-app-launch.jpg',
                'link' => 'https://example.com/mobile-app',
                'button_text' => 'Download App',
                'is_active' => true,
                'order' => 8,
                'start_date' => now()->addDays(7)->toDateString(), // Scheduled
                'end_date' => now()->addDays(37)->toDateString(),
            ],
        ];

        foreach ($sliders as $sliderData) {
            Slider::create($sliderData);
        }

        $this->command->info('✅ Sliders seeded successfully!');
        $this->command->info('📊 Total sliders created: ' . count($sliders));
        
        // Show statistics
        $this->showStatistics();
    }

    /**
     * Show slider statistics
     */
    private function showStatistics(): void
    {
        $stats = [
            'total_sliders' => Slider::count(),
            'active_sliders' => Slider::currentlyActive()->count(),
            'scheduled_sliders' => Slider::scheduled()->count(),
            'expired_sliders' => Slider::expired()->count(),
            'inactive_sliders' => Slider::where('is_active', false)->count(),
            'sliders_with_links' => Slider::whereNotNull('link')->count(),
            'sliders_with_buttons' => Slider::whereNotNull('button_text')->count(),
        ];

        $this->command->info('');
        $this->command->info('📈 SLIDER STATISTICS:');
        $this->command->info('• Total Sliders: ' . number_format($stats['total_sliders']));
        $this->command->info('• Currently Active: ' . number_format($stats['active_sliders']));
        $this->command->info('• Scheduled: ' . number_format($stats['scheduled_sliders']));
        $this->command->info('• Expired: ' . number_format($stats['expired_sliders']));
        $this->command->info('• Inactive: ' . number_format($stats['inactive_sliders']));
        $this->command->info('• With Links: ' . number_format($stats['sliders_with_links']));
        $this->command->info('• With Buttons: ' . number_format($stats['sliders_with_buttons']));
    }
}