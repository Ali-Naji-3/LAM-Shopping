<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing attribute values
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AttributeValue::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get attributes and create values for each
        $attributes = Attribute::all();

        foreach ($attributes as $attribute) {
            $values = [];
            
            switch (strtolower($attribute->name)) {
                case 'color':
                    $values = [
                        'Black', 'White', 'Red', 'Blue', 'Green', 
                        'Yellow', 'Pink', 'Purple', 'Orange', 'Brown', 
                        'Gray', 'Navy', 'Beige', 'Maroon', 'Turquoise'
                    ];
                    break;
                    
                case 'size':
                    $values = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                    break;
                    
                case 'material':
                    $values = [
                        'Cotton', 'Polyester', 'Wool', 'Silk', 'Linen', 
                        'Denim', 'Leather', 'Synthetic', 'Bamboo', 'Cashmere'
                    ];
                    break;
                    
                case 'brand':
                    $values = [
                        'Nike', 'Adidas', 'Puma', 'Reebok', 'Under Armour',
                        'New Balance', 'Converse', 'Vans', 'ASICS', 'Jordan'
                    ];
                    break;
                    
                case 'style':
                    $values = [
                        'Casual', 'Formal', 'Sport', 'Business', 'Party',
                        'Wedding', 'Beach', 'Winter', 'Summer', 'Vintage'
                    ];
                    break;
                    
                case 'fit':
                    $values = [
                        'Slim Fit', 'Regular Fit', 'Loose Fit', 'Tight Fit',
                        'Relaxed Fit', 'Athletic Fit', 'Oversized'
                    ];
                    break;
                    
                case 'pattern':
                    $values = [
                        'Solid', 'Striped', 'Polka Dot', 'Floral', 'Geometric',
                        'Animal Print', 'Plaid', 'Checkered', 'Abstract'
                    ];
                    break;
                    
                case 'season':
                    $values = ['Spring', 'Summer', 'Autumn', 'Winter', 'All Season'];
                    break;
                    
                case 'gender':
                    $values = ['Men', 'Women', 'Boys', 'Girls', 'Unisex'];
                    break;
                    
                case 'occasion':
                    $values = [
                        'Daily Wear', 'Office', 'Party', 'Wedding', 'Sports',
                        'Travel', 'Beach', 'Gym', 'Date Night', 'Casual Outing'
                    ];
                    break;
                    
                default:
                    // For other attributes, create some generic values
                    $values = [
                        'Option 1', 'Option 2', 'Option 3', 'Option 4', 'Option 5'
                    ];
                    break;
            }
            
            // Create attribute values
            foreach ($values as $value) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
        }

        $this->command->info('✅ Attribute values seeded successfully!');
        $this->command->info('📊 Created values for ' . $attributes->count() . ' attributes');
        $this->command->info('🎯 Total values created: ' . AttributeValue::count());
    }
}