<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $brands = [
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'description' => 'Leading athletic footwear and apparel brand known for innovation and performance.',
                'is_active' => true,
            ],
            [
                'name' => 'Adidas',
                'slug' => 'adidas',
                'description' => 'German multinational corporation that designs and manufactures shoes, clothing and accessories.',
                'is_active' => true,
            ],
            [
                'name' => 'Puma',
                'slug' => 'puma',
                'description' => 'Designs and manufactures athletic and casual footwear, apparel and accessories.',
                'is_active' => true,
            ],
            [
                'name' => 'Gucci',
                'slug' => 'gucci',
                'description' => 'Italian luxury brand of fashion and leather goods, known for iconic designs.',
                'is_active' => true,
            ],
            [
                'name' => 'Louis Vuitton',
                'slug' => 'louis-vuitton',
                'description' => 'French fashion house renowned for luxury leather goods and monogram.',
                'is_active' => true,
            ],
            [
                'name' => 'Dior',
                'slug' => 'dior',
                'description' => 'Famous French luxury fashion brand, specializing in haute couture and accessories.',
                'is_active' => true,
            ],
            [
                'name' => 'D&G',
                'slug' => 'dg',
                'description' => 'Italian luxury fashion house known for stylish and high-end clothing.',
                'is_active' => true,
            ],
            [
                'name' => 'Prada',
                'slug' => 'prada',
                'description' => 'American fashion house specializing in minimalist aesthetics, denim, and underwear.',
                'is_active' => true,
            ],
            [
                'name' => 'Levi\'s',
                'slug' => 'levis',
                'description' => 'American clothing company known worldwide for its denim jeans since 1853.',
                'is_active' => true,
            ],
            [
                'name' => 'Supreme',
                'slug' => 'supreme',
                'description' => 'Streetwear brand known for limited releases and hype culture.',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        $this->command->info('✅ 10 Brands seeded successfully without images!');
    }
}
