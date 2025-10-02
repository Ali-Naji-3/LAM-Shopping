<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ========== MEN CATEGORY ==========
        $men = Category::create([
            'name' => 'Men',
            'slug' => 'men',
            'description' => 'Stylish and modern clothing, shoes, and accessories for men.',
            'is_active' => true,
            'order' => 1,
            'frontend_page_url' => '/listing-grid-3',
        ]);

        // Men Subcategories
        Category::create([
            'name' => 'Men Shirts & T-Shirts',
            'slug' => 'men-shirts-tshirts',
            'description' => 'Casual and formal shirts, polo shirts, and t-shirts for men.',
            'parent_id' => $men->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Men Pants & Jeans',
            'slug' => 'men-pants-jeans',
            'description' => 'Comfortable pants, jeans, chinos, and trousers for men.',
            'parent_id' => $men->id,
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Men Shoes & Sneakers',
            'slug' => 'men-shoes-sneakers',
            'description' => 'Stylish shoes, sneakers, boots, and sandals for men.',
            'parent_id' => $men->id,
            'is_active' => true,
            'order' => 3,
        ]);

        // ========== WOMEN CATEGORY ==========
        $women = Category::create([
            'name' => 'Women',
            'slug' => 'women',
            'description' => 'Elegant and fashionable clothing, shoes, and accessories for women.',
            'is_active' => true,
            'order' => 2,
            'frontend_page_url' => '/listing-grid-1-full',
        ]);

        // Women Subcategories
        Category::create([
            'name' => 'Women Dresses & Skirts',
            'slug' => 'women-dresses-skirts',
            'description' => 'Beautiful dresses, skirts, and evening wear for women.',
            'parent_id' => $women->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Women Tops & Blouses',
            'slug' => 'women-tops-blouses',
            'description' => 'Stylish tops, blouses, shirts, and sweaters for women.',
            'parent_id' => $women->id,
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Women Shoes & Heels',
            'slug' => 'women-shoes-heels',
            'description' => 'Fashionable shoes, heels, flats, and sandals for women.',
            'parent_id' => $women->id,
            'is_active' => true,
            'order' => 3,
        ]);

        // ========== BOYS CATEGORY ==========
        $boys = Category::create([
            'name' => 'Boys',
            'slug' => 'boys',
            'description' => 'Fun and comfortable clothing, shoes, and accessories for boys.',
            'is_active' => true,
            'order' => 3,
            'frontend_page_url' => '/listing-grid-2-full',
        ]);

        // Boys Subcategories
        Category::create([
            'name' => 'Boys T-Shirts & Tops',
            'slug' => 'boys-tshirts-tops',
            'description' => 'Cool t-shirts, tops, and casual shirts for boys.',
            'parent_id' => $boys->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Boys Shorts & Pants',
            'slug' => 'boys-shorts-pants',
            'description' => 'Comfortable shorts, pants, and jeans for boys.',
            'parent_id' => $boys->id,
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Boys Sneakers & Shoes',
            'slug' => 'boys-sneakers-shoes',
            'description' => 'Sporty sneakers, shoes, and sandals for boys.',
            'parent_id' => $boys->id,
            'is_active' => true,
            'order' => 3,
        ]);

        // ========== GIRLS CATEGORY ==========
        $girls = Category::create([
            'name' => 'Girls',
            'slug' => 'girls',
            'description' => 'Cute and stylish clothing, shoes, and accessories for girls.',
            'is_active' => true,
            'order' => 4,
            'frontend_page_url' => '/girls',
        ]);

        // Girls Subcategories
        Category::create([
            'name' => 'Girls Dresses & Skirts',
            'slug' => 'girls-dresses-skirts',
            'description' => 'Pretty dresses, skirts, and party wear for girls.',
            'parent_id' => $girls->id,
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Girls Tops & Shirts',
            'slug' => 'girls-tops-shirts',
            'description' => 'Cute tops, shirts, and blouses for girls.',
            'parent_id' => $girls->id,
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Girls Shoes & Sandals',
            'slug' => 'girls-shoes-sandals',
            'description' => 'Adorable shoes, sandals, and sneakers for girls.',
            'parent_id' => $girls->id,
            'is_active' => true,
            'order' => 3,
        ]);

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('📊 Parent Categories: 4 (Men, Women, Boys, Girls)');
        $this->command->info('📂 Subcategories per parent: 3');
        $this->command->info('📁 Total categories: ' . Category::count());
        $this->command->info('🟢 Active categories: ' . Category::where('is_active', true)->count());
    }
}