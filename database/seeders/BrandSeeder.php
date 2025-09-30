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
            // ========== SPORTSWEAR BRANDS ==========
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
                'name' => 'Puma',
                'slug' => 'puma',
                'description' => 'German multinational corporation that designs and manufactures athletic and casual footwear, apparel and accessories.',
                'is_active' => true,
            ],
            [
                'name' => 'Under Armour',
                'slug' => 'under-armour',
                'description' => 'American sports equipment company that manufactures footwear, sports and casual apparel.',
                'is_active' => true,
            ],
            [
                'name' => 'Reebok',
                'slug' => 'reebok',
                'description' => 'British-American footwear and apparel company, specializing in athletic shoes, apparel and accessories.',
                'is_active' => true,
            ],
            
            // ========== LUXURY BRANDS ==========
            [
                'name' => 'Gucci',
                'slug' => 'gucci',
                'description' => 'Italian luxury brand of fashion and leather goods, known for iconic designs and craftsmanship.',
                'is_active' => true,
            ],
            [
                'name' => 'Louis Vuitton',
                'slug' => 'louis-vuitton',
                'description' => 'French fashion house and luxury goods company founded in 1854, renowned for leather goods and monogram.',
                'is_active' => true,
            ],
            [
                'name' => 'Prada',
                'slug' => 'prada',
                'description' => 'Italian luxury fashion house specializing in leather handbags, travel accessories, shoes, ready-to-wear, perfumes.',
                'is_active' => true,
            ],
            [
                'name' => 'Versace',
                'slug' => 'versace',
                'description' => 'Italian luxury fashion company founded by Gianni Versace, known for bold designs and vibrant prints.',
                'is_active' => true,
            ],
            [
                'name' => 'Burberry',
                'slug' => 'burberry',
                'description' => 'British luxury fashion house established in 1856, famous for its iconic trench coat and check pattern.',
                'is_active' => true,
            ],
            
            // ========== FAST FASHION ==========
            [
                'name' => 'Zara',
                'slug' => 'zara',
                'description' => 'Spanish fast fashion retailer known for trendy, affordable clothing for men, women, and children.',
                'is_active' => true,
            ],
            [
                'name' => 'H&M',
                'slug' => 'hm',
                'description' => 'Swedish multinational clothing-retail company known for fast-fashion clothing for all ages.',
                'is_active' => true,
            ],
            [
                'name' => 'Forever 21',
                'slug' => 'forever-21',
                'description' => 'American fast fashion retailer offering trendy clothing and accessories at affordable prices.',
                'is_active' => true,
            ],
            [
                'name' => 'Mango',
                'slug' => 'mango',
                'description' => 'Spanish clothing design and manufacturing company, known for contemporary fashion.',
                'is_active' => true,
            ],
            
            // ========== PREMIUM CASUAL ==========
            [
                'name' => 'Calvin Klein',
                'slug' => 'calvin-klein',
                'description' => 'American fashion house specializing in minimalist aesthetics, denim, underwear, and fragrances.',
                'is_active' => true,
            ],
            [
                'name' => 'Tommy Hilfiger',
                'slug' => 'tommy-hilfiger',
                'description' => 'American premium clothing brand with classic American cool style, known for preppy designs.',
                'is_active' => true,
            ],
            [
                'name' => 'Ralph Lauren',
                'slug' => 'ralph-lauren',
                'description' => 'American fashion company known for Polo Ralph Lauren, offering classic, preppy American style.',
                'is_active' => true,
            ],
            [
                'name' => 'Lacoste',
                'slug' => 'lacoste',
                'description' => 'French clothing company famous for its iconic crocodile logo and tennis-inspired apparel.',
                'is_active' => true,
            ],
            
            // ========== DENIM & BASICS ==========
            [
                'name' => 'Levi\'s',
                'slug' => 'levis',
                'description' => 'American clothing company known worldwide for its Levi\'s brand of denim jeans since 1853.',
                'is_active' => true,
            ],
            [
                'name' => 'Gap',
                'slug' => 'gap',
                'description' => 'American worldwide clothing and accessories retailer offering casual apparel and accessories.',
                'is_active' => true,
            ],
            [
                'name' => 'Uniqlo',
                'slug' => 'uniqlo',
                'description' => 'Japanese casual wear designer known for quality basics, innovative fabrics, and LifeWear philosophy.',
                'is_active' => true,
            ],
            
            // ========== KIDS & FAMILY ==========
            [
                'name' => 'Carter\'s',
                'slug' => 'carters',
                'description' => 'Leading American brand of children\'s clothing, offering quality and comfortable apparel for babies and kids.',
                'is_active' => true,
            ],
            [
                'name' => 'OshKosh B\'gosh',
                'slug' => 'oshkosh-bgosh',
                'description' => 'American children\'s apparel company founded in 1895, known for durable and fun children\'s clothing.',
                'is_active' => true,
            ],
            
            // ========== STREETWEAR & URBAN ==========
            [
                'name' => 'Supreme',
                'slug' => 'supreme',
                'description' => 'American skateboarding lifestyle brand and streetwear company known for limited releases and hype culture.',
                'is_active' => true,
            ],
            [
                'name' => 'The North Face',
                'slug' => 'the-north-face',
                'description' => 'American outdoor recreation products company specializing in outerwear, fleece, coats, and equipment.',
                'is_active' => true,
            ],
            
            // ========== INACTIVE (for testing) ==========
            [
                'name' => 'Old Navy',
                'slug' => 'old-navy',
                'description' => 'American clothing and accessories retailing company owned by Gap Inc.',
                'is_active' => false,
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