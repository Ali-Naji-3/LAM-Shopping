<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;

echo "📏 Testing Size System\n";
echo "=====================\n\n";

// Get the test product
$product = Product::find(25);
if (!$product) {
    echo "❌ Test product not found. Please run the color test first.\n";
    exit;
}

echo "✅ Product found: {$product->name}\n";

// Get or create size attribute
$sizeAttribute = Attribute::where('slug', 'size')->first();
if (!$sizeAttribute) {
    $sizeAttribute = Attribute::create([
        'name' => 'Size',
        'slug' => 'size',
        'type' => 'select',
        'is_required' => false
    ]);
    echo "✅ Size attribute created\n";
} else {
    echo "✅ Size attribute found\n";
}

// Add test sizes
$sizes = [
    ['name' => 'S', 'guide' => 'Chest: 34-36 inches'],
    ['name' => 'M', 'guide' => 'Chest: 36-38 inches'],
    ['name' => 'L', 'guide' => 'Chest: 38-40 inches'],
    ['name' => 'XL', 'guide' => 'Chest: 40-42 inches']
];

echo "\n📏 Adding sizes to product:\n";
foreach ($sizes as $sizeData) {
    $attributeValue = AttributeValue::firstOrCreate([
        'attribute_id' => $sizeAttribute->id,
        'value' => $sizeData['name']
    ]);
    
    ProductAttribute::create([
        'product_id' => $product->id,
        'attribute_value_id' => $attributeValue->id,
        'additional_price' => 0.00
    ]);
    
    echo "  ✅ Added size: {$sizeData['name']} ({$sizeData['guide']})\n";
}

// Verify sizes were added
$sizeCount = $product->productAttributes()
    ->whereHas('attributeValue.attribute', function($q) {
        $q->where('slug', 'size');
    })
    ->count();

echo "\n📊 Verification:\n";
echo "  Total sizes added: {$sizeCount}\n";

// Get the sizes for display
$productSizes = $product->productAttributes()
    ->whereHas('attributeValue.attribute', function($q) {
        $q->where('slug', 'size');
    })
    ->with('attributeValue')
    ->get();

echo "\n📏 Sizes in database:\n";
foreach ($productSizes as $sizeAttr) {
    echo "  • {$sizeAttr->attributeValue->value}\n";
}

echo "\n🌐 Frontend URL: http://127.0.0.1:8000/product/{$product->slug}\n";
echo "🔧 Admin URL: http://127.0.0.1:8000/admin/products/{$product->id}/edit\n";

echo "\n✅ Size system test complete! You can now test the frontend display.\n";
