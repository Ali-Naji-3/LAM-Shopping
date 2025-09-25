<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Root Categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices, gadgets, and accessories for modern living.',
            'is_active' => true,
            'order' => 1,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing & Fashion',
            'slug' => 'clothing-fashion',
            'description' => 'Trendy clothing and fashion accessories for all ages and styles.',
            'is_active' => true,
            'order' => 2,
        ]);

        $homeGarden = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'description' => 'Everything you need to make your house a beautiful and comfortable home.',
            'is_active' => true,
            'order' => 3,
        ]);

        $sports = Category::create([
            'name' => 'Sports & Outdoors',
            'slug' => 'sports-outdoors',
            'description' => 'Sports equipment, outdoor gear, and fitness accessories.',
            'is_active' => true,
            'order' => 4,
        ]);

        $books = Category::create([
            'name' => 'Books & Media',
            'slug' => 'books-media',
            'description' => 'Books, magazines, digital media, and educational materials.',
            'is_active' => true,
            'order' => 5,
        ]);

        // Electronics Sub-categories
        $smartphones = Category::create([
            'name' => 'Smartphones',
            'slug' => 'smartphones',
            'description' => 'Latest smartphones from top brands with cutting-edge technology.',
            'parent_id' => $electronics->id,
            'is_active' => true,
            'order' => 1,
        ]);

        $laptops = Category::create([
            'name' => 'Laptops & Computers',
            'slug' => 'laptops-computers',
            'description' => 'High-performance laptops, desktops, and computer accessories.',
            'parent_id' => $electronics->id,
            'is_active' => true,
            'order' => 2,
        ]);

        $accessories = Category::create([
            'name' => 'Electronics Accessories',
            'slug' => 'electronics-accessories',
            'description' => 'Chargers, cases, cables, and other electronic accessories.',
            'parent_id' => $electronics->id,
            'is_active' => true,
            'order' => 3,
        ]);

        $gaming = Category::create([
            'name' => 'Gaming',
            'slug' => 'gaming',
            'description' => 'Gaming consoles, games, and gaming accessories.',
            'parent_id' => $electronics->id,
            'is_active' => true,
            'order' => 4,
        ]);

        // Clothing Sub-categories
        $menClothing = Category::create([
            'name' => "Men's Clothing",
            'slug' => 'mens-clothing',
            'description' => 'Stylish and comfortable clothing for men of all ages.',
            'parent_id' => $clothing->id,
            'is_active' => true,
            'order' => 1,
        ]);

        $womenClothing = Category::create([
            'name' => "Women's Clothing",
            'slug' => 'womens-clothing',
            'description' => 'Fashionable and elegant clothing for women.',
            'parent_id' => $clothing->id,
            'is_active' => true,
            'order' => 2,
        ]);

        $kidsClothing = Category::create([
            'name' => "Kids' Clothing",
            'slug' => 'kids-clothing',
            'description' => 'Cute and comfortable clothing for children.',
            'parent_id' => $clothing->id,
            'is_active' => true,
            'order' => 3,
        ]);

        $shoes = Category::create([
            'name' => 'Shoes & Footwear',
            'slug' => 'shoes-footwear',
            'description' => 'Comfortable and stylish shoes for every occasion.',
            'parent_id' => $clothing->id,
            'is_active' => true,
            'order' => 4,
        ]);

        // Home & Garden Sub-categories
        $furniture = Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
            'description' => 'Quality furniture for every room in your home.',
            'parent_id' => $homeGarden->id,
            'is_active' => true,
            'order' => 1,
        ]);

        $decor = Category::create([
            'name' => 'Home Decor',
            'slug' => 'home-decor',
            'description' => 'Beautiful decorative items to enhance your living space.',
            'parent_id' => $homeGarden->id,
            'is_active' => true,
            'order' => 2,
        ]);

        $kitchen = Category::create([
            'name' => 'Kitchen & Dining',
            'slug' => 'kitchen-dining',
            'description' => 'Kitchen appliances, cookware, and dining essentials.',
            'parent_id' => $homeGarden->id,
            'is_active' => true,
            'order' => 3,
        ]);

        $garden = Category::create([
            'name' => 'Garden & Outdoor',
            'slug' => 'garden-outdoor',
            'description' => 'Gardening tools, plants, and outdoor living essentials.',
            'parent_id' => $homeGarden->id,
            'is_active' => true,
            'order' => 4,
        ]);

        // Sports Sub-categories
        $fitness = Category::create([
            'name' => 'Fitness Equipment',
            'slug' => 'fitness-equipment',
            'description' => 'Exercise equipment and fitness accessories for home workouts.',
            'parent_id' => $sports->id,
            'is_active' => true,
            'order' => 1,
        ]);

        $outdoor = Category::create([
            'name' => 'Outdoor Activities',
            'slug' => 'outdoor-activities',
            'description' => 'Gear for hiking, camping, and outdoor adventures.',
            'parent_id' => $sports->id,
            'is_active' => true,
            'order' => 2,
        ]);

        $teamSports = Category::create([
            'name' => 'Team Sports',
            'slug' => 'team-sports',
            'description' => 'Equipment for football, basketball, soccer, and other team sports.',
            'parent_id' => $sports->id,
            'is_active' => true,
            'order' => 3,
        ]);

        // Books Sub-categories
        $fiction = Category::create([
            'name' => 'Fiction',
            'slug' => 'fiction',
            'description' => 'Novels, short stories, and fictional literature.',
            'parent_id' => $books->id,
            'is_active' => true,
            'order' => 1,
        ]);

        $nonFiction = Category::create([
            'name' => 'Non-Fiction',
            'slug' => 'non-fiction',
            'description' => 'Educational, biographical, and factual books.',
            'parent_id' => $books->id,
            'is_active' => true,
            'order' => 2,
        ]);

        $educational = Category::create([
            'name' => 'Educational',
            'slug' => 'educational',
            'description' => 'Textbooks, study guides, and educational materials.',
            'parent_id' => $books->id,
            'is_active' => true,
            'order' => 3,
        ]);

        // Create some sample contacts for categories with contact integration
        $this->createSampleContacts($electronics);
        $this->createSampleContacts($clothing);
        $this->createSampleContacts($smartphones);
        $this->createSampleContacts($laptops);
        $this->createSampleContacts($menClothing);
        $this->createSampleContacts($furniture);
    }

    /**
     * Create sample contacts for a category
     */
    private function createSampleContacts(Category $category): void
    {
        $contactTypes = ['inquiry', 'complaint', 'suggestion', 'other'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['pending', 'resolved'];

        $sampleContacts = [
            [
                'subject' => "Question about {$category->name} products",
                'message' => "Hi, I'm interested in learning more about the {$category->name} products you offer. Could you provide more details about the available options and pricing?",
                'contact_type' => 'inquiry',
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'subject' => "Suggestion for {$category->name} category",
                'message' => "I think it would be great if you could add more variety to your {$category->name} section. Maybe consider adding some eco-friendly options?",
                'contact_type' => 'suggestion',
                'priority' => 'low',
                'status' => 'resolved',
            ],
            [
                'subject' => "Issue with {$category->name} product search",
                'message' => "I'm having trouble finding specific products in the {$category->name} category. The search function doesn't seem to work properly for this section.",
                'contact_type' => 'complaint',
                'priority' => 'high',
                'status' => 'pending',
            ],
        ];

        foreach ($sampleContacts as $contactData) {
            $contact = Contact::create([
                'category_id' => $category->id,
                'user_id' => 1, // Assuming admin user ID is 1
                'subject' => $contactData['subject'],
                'message' => $contactData['message'],
                'contact_type' => $contactData['contact_type'],
                'priority' => $contactData['priority'],
                'status' => $contactData['status'],
            ]);

            // Add a sample response for resolved contacts
            if ($contact->status === 'resolved') {
                $contact->responses()->create([
                    'user_id' => 1,
                    'message' => "Thank you for your feedback regarding {$category->name}. We appreciate your suggestion and will consider it for future updates to our catalog.",
                ]);
            }
        }
    }
}
