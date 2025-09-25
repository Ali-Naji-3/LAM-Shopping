<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Clear existing brands (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $brands = [
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'description' => 'Just Do It - Leading athletic footwear and apparel brand known for innovation and performance.',
                'is_active' => true,
            ],
            [
                'name' => 'Adidas',
                'slug' => 'adidas',
                'description' => 'Impossible is Nothing - German multinational corporation that designs and manufactures shoes, clothing and accessories.',
                'is_active' => true,
            ],
            [
                'name' => 'Zara',
                'slug' => 'zara',
                'description' => 'Spanish fast fashion retailer known for trendy, affordable clothing for men, women, and children.',
                'is_active' => true,
            ],
            [
                'name' => 'H&M',
                'slug' => 'hm',
                'description' => 'Swedish multinational clothing-retail company known for fast-fashion clothing for men, women, teenagers, and children.',
                'is_active' => true,
            ],
            [
                'name' => 'Gucci',
                'slug' => 'gucci',
                'description' => 'Italian luxury brand of fashion and leather goods, part of the Gucci Group, which is owned by French company Kering.',
                'is_active' => true,
            ],
            [
                'name' => 'Louis Vuitton',
                'slug' => 'louis-vuitton',
                'description' => 'French fashion house and luxury goods company founded in 1854 by Louis Vuitton.',
                'is_active' => true,
            ],
            [
                'name' => 'Puma',
                'slug' => 'puma',
                'description' => 'German multinational corporation that designs and manufactures athletic and casual footwear, apparel and accessories.',
                'is_active' => true,
            ],
            [
                'name' => 'Uniqlo',
                'slug' => 'uniqlo',
                'description' => 'Japanese casual wear designer, manufacturer and retailer known for quality basics and innovative fabrics.',
                'is_active' => true,
            ],
            [
                'name' => 'Calvin Klein',
                'slug' => 'calvin-klein',
                'description' => 'American fashion house established in 1968 specializing in leather, lifestyle accessories, home furnishings, perfumery, jewellery, watches and ready-to-wear.',
                'is_active' => true,
            ],
            [
                'name' => 'Tommy Hilfiger',
                'slug' => 'tommy-hilfiger',
                'description' => 'American premium clothing brand, manufacturing apparel, footwear, accessories, fragrances and home furnishings.',
                'is_active' => true,
            ],
            [
                'name' => 'Levi\'s',
                'slug' => 'levis',
                'description' => 'American clothing company known worldwide for its Levi\'s brand of denim jeans.',
                'is_active' => true,
            ],
            [
                'name' => 'Forever 21',
                'slug' => 'forever-21',
                'description' => 'American fast fashion retailer headquartered in Los Angeles, California.',
                'is_active' => false, // Some inactive for testing
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        $this->command->info('✅ Brands seeded successfully!');
        $this->command->info('📊 Total brands created: ' . count($brands));
        $this->command->info('🟢 Active brands: ' . collect($brands)->where('is_active', true)->count());
        $this->command->info('🔴 Inactive brands: ' . collect($brands)->where('is_active', false)->count());
    }
}