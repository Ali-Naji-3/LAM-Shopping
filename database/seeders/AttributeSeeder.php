<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing attributes
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AttributeValue::truncate();
        Attribute::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $attributes = [
            [
                'name' => 'Size',
                'slug' => 'size',
                'type' => 'select',
                'is_required' => true,
                'values' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Color',
                'slug' => 'color',
                'type' => 'select',
                'is_required' => true,
                'values' => ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Pink', 'Gray', 'Brown']
            ],
            [
                'name' => 'Material',
                'slug' => 'material',
                'type' => 'select',
                'is_required' => false,
                'values' => ['Cotton', 'Polyester', 'Wool', 'Silk', 'Leather', 'Denim', 'Linen', 'Synthetic']
            ],
            [
                'name' => 'Features',
                'slug' => 'features',
                'type' => 'checkbox',
                'is_required' => false,
                'values' => ['Waterproof', 'Breathable', 'Anti-bacterial', 'UV Protection', 'Quick Dry', 'Stretchable']
            ],
            [
                'name' => 'Gender',
                'slug' => 'gender',
                'type' => 'radio',
                'is_required' => true,
                'values' => ['Men', 'Women', 'Unisex', 'Boys', 'Girls']
            ],
            [
                'name' => 'Style',
                'slug' => 'style',
                'type' => 'select',
                'is_required' => false,
                'values' => ['Casual', 'Formal', 'Sport', 'Business', 'Evening', 'Vintage', 'Modern']
            ],
            [
                'name' => 'Season',
                'slug' => 'season',
                'type' => 'radio',
                'is_required' => false,
                'values' => ['Spring', 'Summer', 'Fall', 'Winter', 'All Season']
            ],
            [
                'name' => 'Care Instructions',
                'slug' => 'care-instructions',
                'type' => 'text',
                'is_required' => false,
                'values' => [] // Text type doesn't need predefined values
            ],
            [
                'name' => 'Shoe Size',
                'slug' => 'shoe-size',
                'type' => 'select',
                'is_required' => false,
                'values' => ['6', '6.5', '7', '7.5', '8', '8.5', '9', '9.5', '10', '10.5', '11', '11.5', '12']
            ],
            [
                'name' => 'Brand Features',
                'slug' => 'brand-features',
                'type' => 'checkbox',
                'is_required' => false,
                'values' => ['Limited Edition', 'Eco-Friendly', 'Handmade', 'Premium Quality', 'Designer Collection']
            ],
        ];

        foreach ($attributes as $attributeData) {
            $values = $attributeData['values'];
            unset($attributeData['values']);
            
            $attribute = Attribute::create($attributeData);
            
            // Create attribute values if provided
            if (!empty($values)) {
                foreach ($values as $value) {
                    AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);
                }
            }
        }

        $this->command->info('✅ Attributes seeded successfully!');
        $this->command->info('📊 Total attributes created: ' . count($attributes));
        $this->command->info('🔧 Text attributes: ' . collect($attributes)->where('type', 'text')->count());
        $this->command->info('📋 Select attributes: ' . collect($attributes)->where('type', 'select')->count());
        $this->command->info('☑️ Checkbox attributes: ' . collect($attributes)->where('type', 'checkbox')->count());
        $this->command->info('🔘 Radio attributes: ' . collect($attributes)->where('type', 'radio')->count());
        $this->command->info('⚠️ Required attributes: ' . collect($attributes)->where('is_required', true)->count());
    }
}