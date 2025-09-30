<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;

echo "🧪 Testing Color Dots System\n";
echo "============================\n\n";

// Create a test product
$product = Product::create([
    'name' => 'Test Color Product',
    'slug' => 'test-color-product-' . time(),
    'description' => 'A test product to verify color dots functionality',
    'regular_price' => 29.99,
    'sale_price' => 24.99,
    'quantity' => 50,
    'category_id' => 1,
    'brand_id' => 1,
    'status' => 'active',
    'featured' => false,
    'sku' => 'TEST-COLOR-' . time(),
    'image' => 'products/test-image.jpg'
]);

echo "✅ Product created: {$product->name} (ID: {$product->id})\n";
echo "📝 Product slug: {$product->slug}\n\n";

// Get or create color attribute
$colorAttribute = Attribute::where('slug', 'color')->first();
if (!$colorAttribute) {
    $colorAttribute = Attribute::create([
        'name' => 'Color',
        'slug' => 'color',
        'type' => 'select',
        'is_required' => false
    ]);
    echo "✅ Color attribute created\n";
} else {
    echo "✅ Color attribute found\n";
}

// Add test colors
$colors = [
    ['name' => 'Red', 'hex' => '#ff0000'],
    ['name' => 'Blue', 'hex' => '#0000ff'],
    ['name' => 'Green', 'hex' => '#00ff00'],
    ['name' => 'Yellow', 'hex' => '#ffff00']
];

echo "\n🎨 Adding colors to product:\n";
foreach ($colors as $colorData) {
    $attributeValue = AttributeValue::firstOrCreate([
        'attribute_id' => $colorAttribute->id,
        'value' => $colorData['name']
    ]);
    
    ProductAttribute::create([
        'product_id' => $product->id,
        'attribute_value_id' => $attributeValue->id,
        'additional_price' => 0.00
    ]);
    
    echo "  ✅ Added color: {$colorData['name']} ({$colorData['hex']})\n";
}

// Verify colors were added
$colorCount = $product->productAttributes()
    ->whereHas('attributeValue.attribute', function($q) {
        $q->where('slug', 'color');
    })
    ->count();

echo "\n📊 Verification:\n";
echo "  Total colors added: {$colorCount}\n";

// Get the colors for display
$productColors = $product->productAttributes()
    ->whereHas('attributeValue.attribute', function($q) {
        $q->where('slug', 'color');
    })
    ->with('attributeValue')
    ->get();

echo "\n🎯 Colors in database:\n";
foreach ($productColors as $colorAttr) {
    echo "  • {$colorAttr->attributeValue->value}\n";
}

echo "\n🌐 Frontend URL: http://127.0.0.1:8000/product/{$product->slug}\n";
echo "🔧 Admin URL: http://127.0.0.1:8000/admin/products/{$product->id}/edit\n";

echo "\n✅ Test setup complete! You can now test the frontend display.\n";
