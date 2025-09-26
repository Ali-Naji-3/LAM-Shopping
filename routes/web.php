<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
Route::post('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');


Route::get('/product', [DashboardController::class, 'product'])->name('admin.product');
Route::get('/addproduct', [DashboardController::class, 'add_product'])->name('admin.create');
Route::get('/editproduct', [DashboardController::class, 'edit_product'])->name('admin.edit');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/product/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');

// Category Frontend Routes
Route::get('/men', [HomeController::class, 'categoryPage'])->name('category.men');
Route::get('/women', [HomeController::class, 'categoryPage'])->name('category.women');
Route::get('/body', [HomeController::class, 'categoryPage'])->name('category.body');
Route::get('/girl', [HomeController::class, 'categoryPage'])->name('category.girl');
Route::get('/category/{slug}', [HomeController::class, 'categoryPage'])->name('category.show');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (protected by auth and admin middleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Categories Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy'
    ]);

    // Additional Categories Routes
    Route::post('categories/bulk-action', [App\Http\Controllers\Admin\CategoryController::class, 'bulkActions'])->name('admin.categories.bulk');
    Route::post('categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle');
    Route::post('categories/reorder', [App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('admin.categories.reorder');

    // Contact integration routes for Categories
    Route::get('categories/{category}/contacts', [App\Http\Controllers\Admin\CategoryController::class, 'contacts'])->name('admin.categories.contacts');
    Route::post('categories/{category}/contacts', [App\Http\Controllers\Admin\CategoryController::class, 'storeContact'])->name('admin.categories.contacts.store');

    // ENHANCED CATEGORY CONNECTIONS - Complete CRUD Integration
    Route::get('categories/{category}/products', [App\Http\Controllers\Admin\CategoryController::class, 'products'])->name('admin.categories.products');
    Route::get('categories/{category}/brands', [App\Http\Controllers\Admin\CategoryController::class, 'brands'])->name('admin.categories.brands');
    Route::get('categories/{category}/reviews', [App\Http\Controllers\Admin\CategoryController::class, 'reviews'])->name('admin.categories.reviews');
    Route::get('categories/{category}/analytics', [App\Http\Controllers\Admin\CategoryController::class, 'analytics'])->name('admin.categories.analytics');

    // Brands Management - Complete CRUD with Connections
    Route::resource('brands', App\Http\Controllers\Admin\BrandController::class)->names([
        'index' => 'admin.brands.index',
        'create' => 'admin.brands.create',
        'store' => 'admin.brands.store',
        'show' => 'admin.brands.show',
        'edit' => 'admin.brands.edit',
        'update' => 'admin.brands.update',
        'destroy' => 'admin.brands.destroy'
    ]);

    // Additional Brands Routes
    Route::post('brands/bulk-action', [App\Http\Controllers\Admin\BrandController::class, 'bulkActions'])->name('admin.brands.bulk');
    Route::post('brands/{brand}/toggle-status', [App\Http\Controllers\Admin\BrandController::class, 'toggleStatus'])->name('admin.brands.toggle');

    // Brand Connection Routes
    Route::get('brands/{brand}/products', [App\Http\Controllers\Admin\BrandController::class, 'products'])->name('admin.brands.products');
    Route::get('brands/{brand}/categories', [App\Http\Controllers\Admin\BrandController::class, 'categories'])->name('admin.brands.categories');
    Route::get('brands/{brand}/contacts', [App\Http\Controllers\Admin\BrandController::class, 'contacts'])->name('admin.brands.contacts');
    Route::post('brands/{brand}/contacts', [App\Http\Controllers\Admin\BrandController::class, 'storeContact'])->name('admin.brands.contacts.store');
    Route::get('brands/{brand}/analytics', [App\Http\Controllers\Admin\BrandController::class, 'analytics'])->name('admin.brands.analytics');

    // Products Management - Complete CRUD with Connections
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy'
    ]);

    // Additional Products Routes
    Route::post('products/bulk-action', [App\Http\Controllers\Admin\ProductController::class, 'bulkActions'])->name('admin.products.bulk');
    Route::post('products/{product}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('admin.products.toggle');
    Route::post('products/{product}/toggle-featured', [App\Http\Controllers\Admin\ProductController::class, 'toggleFeatured'])->name('admin.products.featured');

    // Product Connection Routes
    Route::get('products/{product}/reviews', [App\Http\Controllers\Admin\ProductController::class, 'reviews'])->name('admin.products.reviews');
    Route::get('products/{product}/orders', [App\Http\Controllers\Admin\ProductController::class, 'orders'])->name('admin.products.orders');
    Route::get('products/{product}/inventory', [App\Http\Controllers\Admin\ProductController::class, 'inventory'])->name('admin.products.inventory');
    Route::get('products/{product}/analytics', [App\Http\Controllers\Admin\ProductController::class, 'analytics'])->name('admin.products.analytics');

    // Attributes Management - Complete CRUD with Connections
    Route::resource('attributes', App\Http\Controllers\Admin\AttributeController::class)->names([
        'index' => 'admin.attributes.index',
        'create' => 'admin.attributes.create',
        'store' => 'admin.attributes.store',
        'show' => 'admin.attributes.show',
        'edit' => 'admin.attributes.edit',
        'update' => 'admin.attributes.update',
        'destroy' => 'admin.attributes.destroy'
    ]);

    // Additional Attributes Routes
    Route::post('attributes/bulk-action', [App\Http\Controllers\Admin\AttributeController::class, 'bulkActions'])->name('admin.attributes.bulk');

    // Attribute Connection Routes
    Route::get('attributes/{attribute}/values', [App\Http\Controllers\Admin\AttributeController::class, 'values'])->name('admin.attributes.values');
    Route::get('attributes/{attribute}/products', [App\Http\Controllers\Admin\AttributeController::class, 'products'])->name('admin.attributes.products');
    Route::get('attributes/{attribute}/contacts', [App\Http\Controllers\Admin\AttributeController::class, 'contacts'])->name('admin.attributes.contacts');
    Route::post('attributes/{attribute}/contacts', [App\Http\Controllers\Admin\AttributeController::class, 'storeContact'])->name('admin.attributes.contacts.store');
    Route::get('attributes/{attribute}/analytics', [App\Http\Controllers\Admin\AttributeController::class, 'analytics'])->name('admin.attributes.analytics');

    // Attribute Values Management - Complete CRUD System
    Route::resource('attributeValues', App\Http\Controllers\Admin\AttributeValuesController::class)->names([
        'index' => 'admin.attributeValues.index',
        'create' => 'admin.attributeValues.create',
        'store' => 'admin.attributeValues.store',
        'show' => 'admin.attributeValues.show',
        'edit' => 'admin.attributeValues.edit',
        'update' => 'admin.attributeValues.update',
        'destroy' => 'admin.attributeValues.destroy'
    ]);

    // Additional Attribute Values Routes
    Route::post('attributeValues/bulk-action', [App\Http\Controllers\Admin\AttributeValuesController::class, 'bulkActions'])->name('admin.attributeValues.bulk');
    Route::post('attributeValues/bulk-import', [App\Http\Controllers\Admin\AttributeValuesController::class, 'bulkImport'])->name('admin.attributeValues.import');
    Route::get('attributeValues/{attributeValue}/products', [App\Http\Controllers\Admin\AttributeValuesController::class, 'products'])->name('admin.attributeValues.products');

    // Product Attributes Management - Complete CRUD System
    Route::resource('productAttributes', App\Http\Controllers\Admin\ProductAttributesController::class)->names([
        'index' => 'admin.productAttributes.index',
        'create' => 'admin.productAttributes.create',
        'store' => 'admin.productAttributes.store',
        'show' => 'admin.productAttributes.show',
        'edit' => 'admin.productAttributes.edit',
        'update' => 'admin.productAttributes.update',
        'destroy' => 'admin.productAttributes.destroy'
    ]);

    // Additional Product Attributes Routes
    Route::post('productAttributes/bulk-action', [App\Http\Controllers\Admin\ProductAttributesController::class, 'bulkActions'])->name('admin.productAttributes.bulk');
    Route::post('productAttributes/bulk-assign', [App\Http\Controllers\Admin\ProductAttributesController::class, 'bulkAssign'])->name('admin.productAttributes.bulkAssign');
    Route::get('productAttributes/analytics/dashboard', [App\Http\Controllers\Admin\ProductAttributesController::class, 'analytics'])->name('admin.productAttributes.analytics');

    // Reviews Management - Complete CRUD System
    Route::resource('reviews', App\Http\Controllers\Admin\ReviewsController::class)->names([
        'index' => 'admin.reviews.index',
        'create' => 'admin.reviews.create',
        'store' => 'admin.reviews.store',
        'show' => 'admin.reviews.show',
        'edit' => 'admin.reviews.edit',
        'update' => 'admin.reviews.update',
        'destroy' => 'admin.reviews.destroy'
    ]);

    // Additional Reviews Routes
    Route::post('reviews/bulk-action', [App\Http\Controllers\Admin\ReviewsController::class, 'bulkActions'])->name('admin.reviews.bulk');
    Route::patch('reviews/{review}/toggle-approval', [App\Http\Controllers\Admin\ReviewsController::class, 'toggleApproval'])->name('admin.reviews.toggleApproval');
    Route::get('reviews/product/{product}', [App\Http\Controllers\Admin\ReviewsController::class, 'productReviews'])->name('admin.reviews.product');
    Route::get('reviews/user/{user}', [App\Http\Controllers\Admin\ReviewsController::class, 'userReviews'])->name('admin.reviews.user');
    Route::get('reviews/analytics/dashboard', [App\Http\Controllers\Admin\ReviewsController::class, 'analytics'])->name('admin.reviews.analytics');

    // Sliders Management - Complete CRUD System
    Route::resource('sliders', App\Http\Controllers\Admin\SlidersController::class)->names([
        'index' => 'admin.sliders.index',
        'create' => 'admin.sliders.create',
        'store' => 'admin.sliders.store',
        'show' => 'admin.sliders.show',
        'edit' => 'admin.sliders.edit',
        'update' => 'admin.sliders.update',
        'destroy' => 'admin.sliders.destroy'
    ]);

    // Additional Sliders Routes
    Route::post('sliders/bulk-action', [App\Http\Controllers\Admin\SlidersController::class, 'bulkActions'])->name('admin.sliders.bulk');
    Route::patch('sliders/{slider}/toggle-status', [App\Http\Controllers\Admin\SlidersController::class, 'toggleStatus'])->name('admin.sliders.toggleStatus');
    Route::post('sliders/reorder', [App\Http\Controllers\Admin\SlidersController::class, 'reorder'])->name('admin.sliders.reorder');
    Route::get('sliders/analytics/dashboard', [App\Http\Controllers\Admin\SlidersController::class, 'analytics'])->name('admin.sliders.analytics');

    // Orders Management - Complete CRUD System
    Route::resource('orders', App\Http\Controllers\Admin\OrdersController::class)->names([
        'index' => 'admin.orders.index',
        'create' => 'admin.orders.create',
        'store' => 'admin.orders.store',
        'show' => 'admin.orders.show',
        'edit' => 'admin.orders.edit',
        'update' => 'admin.orders.update',
        'destroy' => 'admin.orders.destroy'
    ]);

    // Additional Orders Routes
    Route::post('orders/bulk-action', [App\Http\Controllers\Admin\OrdersController::class, 'bulkActions'])->name('admin.orders.bulk');
    Route::patch('orders/{order}/update-status', [App\Http\Controllers\Admin\OrdersController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('orders/{order}/update-payment-status', [App\Http\Controllers\Admin\OrdersController::class, 'updatePaymentStatus'])->name('admin.orders.updatePaymentStatus');
    Route::get('orders/analytics/dashboard', [App\Http\Controllers\Admin\OrdersController::class, 'analytics'])->name('admin.orders.analytics');

    // Order Items Management - Complete CRUD System
    Route::resource('orderItems', App\Http\Controllers\Admin\OrderItemsController::class)->names([
        'index' => 'admin.orderItems.index',
        'create' => 'admin.orderItems.create',
        'store' => 'admin.orderItems.store',
        'show' => 'admin.orderItems.show',
        'edit' => 'admin.orderItems.edit',
        'update' => 'admin.orderItems.update',
        'destroy' => 'admin.orderItems.destroy'
    ]);

    // Additional Order Items Routes
    Route::post('orderItems/bulk-action', [App\Http\Controllers\Admin\OrderItemsController::class, 'bulkActions'])->name('admin.orderItems.bulk');
    Route::get('orderItems/analytics/dashboard', [App\Http\Controllers\Admin\OrderItemsController::class, 'analytics'])->name('admin.orderItems.analytics');
    Route::get('orders/{order}/items', [App\Http\Controllers\Admin\OrderItemsController::class, 'getOrderItems'])->name('admin.orderItems.getOrderItems');
    Route::post('orderItems/calculate-total', [App\Http\Controllers\Admin\OrderItemsController::class, 'calculateItemTotal'])->name('admin.orderItems.calculateTotal');

    // Warehouses Management - Complete CRUD System
    Route::resource('warehouses', App\Http\Controllers\Admin\WarehousesController::class)->names([
        'index' => 'admin.warehouses.index',
        'create' => 'admin.warehouses.create',
        'store' => 'admin.warehouses.store',
        'show' => 'admin.warehouses.show',
        'edit' => 'admin.warehouses.edit',
        'update' => 'admin.warehouses.update',
        'destroy' => 'admin.warehouses.destroy'
    ]);

    // Additional Warehouses Routes
    Route::post('warehouses/bulk-action', [App\Http\Controllers\Admin\WarehousesController::class, 'bulkActions'])->name('admin.warehouses.bulk');
    Route::patch('warehouses/{warehouse}/toggle-status', [App\Http\Controllers\Admin\WarehousesController::class, 'toggleStatus'])->name('admin.warehouses.toggleStatus');
    Route::get('warehouses/{warehouse}/inventory', [App\Http\Controllers\Admin\WarehousesController::class, 'inventory'])->name('admin.warehouses.inventory');
    Route::get('warehouses/{warehouse}/contacts', [App\Http\Controllers\Admin\WarehousesController::class, 'contacts'])->name('admin.warehouses.contacts');
    Route::get('warehouses/{warehouse}/analytics', [App\Http\Controllers\Admin\WarehousesController::class, 'analytics'])->name('admin.warehouses.analytics');

    // Inventory Management - Complete CRUD System
    Route::resource('inventory', App\Http\Controllers\Admin\InventoryController::class)->names([
        'index' => 'admin.inventory.index',
        'create' => 'admin.inventory.create',
        'store' => 'admin.inventory.store',
        'show' => 'admin.inventory.show',
        'edit' => 'admin.inventory.edit',
        'update' => 'admin.inventory.update',
        'destroy' => 'admin.inventory.destroy'
    ]);

    // Additional Inventory Routes
    Route::post('inventory/bulk-action', [App\Http\Controllers\Admin\InventoryController::class, 'bulkActions'])->name('admin.inventory.bulk');
    Route::post('inventory/{inventory}/adjust-quantity', [App\Http\Controllers\Admin\InventoryController::class, 'adjustQuantity'])->name('admin.inventory.adjustQuantity');
    Route::get('inventory/analytics/dashboard', [App\Http\Controllers\Admin\InventoryController::class, 'analytics'])->name('admin.inventory.analytics');
    Route::get('inventory/data/get', [App\Http\Controllers\Admin\InventoryController::class, 'getInventoryData'])->name('admin.inventory.getData');

    // Transactions Management - Complete CRUD System
    Route::resource('transactions', App\Http\Controllers\Admin\TransactionsController::class)->names([
        'index' => 'admin.transactions.index',
        'create' => 'admin.transactions.create',
        'store' => 'admin.transactions.store',
        'show' => 'admin.transactions.show',
        'edit' => 'admin.transactions.edit',
        'update' => 'admin.transactions.update',
        'destroy' => 'admin.transactions.destroy'
    ]);

    // Additional Transactions Routes
    Route::post('transactions/bulk-action', [App\Http\Controllers\Admin\TransactionsController::class, 'bulkActions'])->name('admin.transactions.bulk');
    Route::patch('transactions/{transaction}/update-status', [App\Http\Controllers\Admin\TransactionsController::class, 'updateStatus'])->name('admin.transactions.updateStatus');
    Route::post('transactions/{transaction}/refund', [App\Http\Controllers\Admin\TransactionsController::class, 'processRefund'])->name('admin.transactions.refund');
    Route::get('transactions/analytics/dashboard', [App\Http\Controllers\Admin\TransactionsController::class, 'analytics'])->name('admin.transactions.analytics');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Add more admin routes here
});

Route::get('/listing-grid-2-full', function () {
    // Boys Collection - Dynamic
    $products = \App\Models\Product::active()
        ->whereHas('category', function ($q) {
            $q->where('name', 'boy');
        })
        ->with(['category', 'brand'])
        ->orderBy('featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    $categories = \App\Models\Category::active()->rootCategories()->ordered()->get();
    $brands = \App\Models\Brand::active()->get();

    return view('frontend.listing-grid-2-full', compact('products', 'categories', 'brands'));
});

Route::get('/listing-grid-7-sidebar-right', function () {
    return view('frontend.listing-grid-7-sidebar-right');
});

Route::get('/listing-grid-1-full', function () {
    // Women's Collection - Dynamic (including subcategories)
    $womenCategory = \App\Models\Category::where('name', 'Women')->first();

    if (!$womenCategory) {
        abort(404, 'Category not found'); // or handle it gracefully
    }

    $categoryIds = [$womenCategory->id];

    // Get all subcategories of Women
    $subcategories = \App\Models\Category::where('parent_id', $womenCategory->id)->pluck('id');
    $categoryIds = array_merge($categoryIds, $subcategories->toArray());

    $products = \App\Models\Product::active()
        ->whereIn('category_id', $categoryIds)
        ->with(['category', 'brand'])
        ->orderBy('featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    $categories = \App\Models\Category::active()->rootCategories()->ordered()->get();
    $brands = \App\Models\Brand::active()->get();

    return view('frontend.listing-grid-1-full', compact('products', 'categories', 'brands'));
});


Route::get('/listing-grid-3', function () {
    // Men's Collection - Dynamic (including subcategories)
    $menCategory = \App\Models\Category::where('name', 'Men')->first();

    if (!$menCategory) {
        abort(404, 'Men category not found');
    }


    $categoryIds = [$menCategory->id];

    // Get all subcategories of Men
    $subcategories = \App\Models\Category::where('parent_id', $menCategory->id)->pluck('id');
    $categoryIds = array_merge($categoryIds, $subcategories->toArray());


    $products = \App\Models\Product::active()
        ->whereIn('category_id', $categoryIds)
        ->with(['category', 'brand'])
        ->orderBy('featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    
    $categories = \App\Models\Category::active()->rootCategories()->ordered()->get();
    $brands = \App\Models\Brand::active()->get();

    return view('frontend.listing-grid-3', compact('products', 'categories', 'brands'));
})->name('listing.grid3');


Route::get('/girls', function () {
    // Girl's Collection - Dynamic
    $products = \App\Models\Product::active()
        ->whereHas('category', function ($q) {
            $q->where('name', 'Girl');
        })
        ->with(['category', 'brand'])
        ->orderBy('featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    $categories = \App\Models\Category::active()->rootCategories()->ordered()->get();
    $brands = \App\Models\Brand::active()->get();

    return view('frontend.girls', compact('products', 'categories', 'brands'));
});

Route::get('/product-detail-2', function () {
    return view('frontend.product-detail-2');
});

Route::get('/cart', function () {
    return view('frontend.cart');
});

Route::get('/checkout', function () {
    return view('frontend.checkout');
});

Route::get('/confirm', function () {
    return view('frontend.confirm');
});

Route::get('/account', function () {
    return view('frontend.account');
});

Route::get('/track-order', function () {
    return view('frontend.track-order');
});

Route::get('/help', function () {
    return view('frontend.help');
});

Route::get('/leave-review', function () {
    return view('frontend.leave-review');
});

Route::get('/my-orders', function () {
    return view('frontend.my-orders');
});

Route::get('/profile-page', function () {
    return view('frontend.profile-page');
});

Route::get('/my-wishlist', function () {
    return view('frontend.my-wishlist');
});



Route::get('/{page}', function ($page) {
    // Construct the view name from the page parameter
    $viewName = str_replace('.html', '', $page);

    // Check if the view exists
    if (view()->exists($viewName)) {
        return view($viewName);
    } else {
        // Handle cases where the view doesn't exist (e.g., show a 404 page)
        abort(404);
    }
})->where('page', '.*\.html');

Route::get("/admin/dependencies/analyze", [App\Http\Controllers\Admin\DependencyController::class, "analyze"])->name("admin.dependencies.analyze");
