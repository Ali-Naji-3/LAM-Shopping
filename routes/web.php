<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Frontend\FunctionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValuesController;
use App\Http\Controllers\Admin\ProductAttributesController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\SlidersController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\OrderItemsController;
use App\Http\Controllers\Admin\WarehousesController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\CartController;

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

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

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

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (protected by auth and admin middleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    // GENDER-SPECIFIC PRODUCT ROUTES (MUST BE BEFORE RESOURCE ROUTES)
    Route::get('products/men', [App\Http\Controllers\Admin\ProductController::class, 'men'])->name('admin.products.men');
    Route::get('products/women', [App\Http\Controllers\Admin\ProductController::class, 'women'])->name('admin.products.women');
    Route::get('products/boys', [App\Http\Controllers\Admin\ProductController::class, 'boys'])->name('admin.products.boys');
    Route::get('products/girls', [App\Http\Controllers\Admin\ProductController::class, 'girls'])->name('admin.products.girls');

    // Categories Management
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy'
    ]);

    // Additional Categories Routes
    Route::post('categories/bulk-action', [CategoryController::class, 'bulkActions'])->name('admin.categories.bulk');
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle');
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('admin.categories.reorder');

    // Contact integration routes for Categories
    Route::get('categories/{category}/contacts', [CategoryController::class, 'contacts'])->name('admin.categories.contacts');
    Route::post('categories/{category}/contacts', [CategoryController::class, 'storeContact'])->name('admin.categories.contacts.store');

    // ENHANCED CATEGORY CONNECTIONS - Complete CRUD Integration
    Route::get('categories/{category}/products', [CategoryController::class, 'products'])->name('admin.categories.products');
    Route::get('categories/{category}/brands', [CategoryController::class, 'brands'])->name('admin.categories.brands');
    Route::get('categories/{category}/reviews', [CategoryController::class, 'reviews'])->name('admin.categories.reviews');
    Route::get('categories/{category}/analytics', [CategoryController::class, 'analytics'])->name('admin.categories.analytics');


    // Brands Management - Complete CRUD with Connections
    Route::resource('brands', BrandController::class)->names([
        'index' => 'admin.brands.index',
        'create' => 'admin.brands.create',
        'store' => 'admin.brands.store',
        'show' => 'admin.brands.show',
        'edit' => 'admin.brands.edit',
        'update' => 'admin.brands.update',
        'destroy' => 'admin.brands.destroy'
    ]);

    // Additional Brands Routes
    Route::post('brands/bulk-action', [BrandController::class, 'bulkActions'])->name('admin.brands.bulk');
    Route::post('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('admin.brands.toggle');

    // Brand Connection Routes
    Route::get('brands/{brand}/products', [BrandController::class, 'products'])->name('admin.brands.products');
    Route::get('brands/{brand}/categories', [BrandController::class, 'categories'])->name('admin.brands.categories');
    Route::get('brands/{brand}/contacts', [BrandController::class, 'contacts'])->name('admin.brands.contacts');
    Route::post('brands/{brand}/contacts', [BrandController::class, 'storeContact'])->name('admin.brands.contacts.store');
    Route::get('brands/{brand}/analytics', [BrandController::class, 'analytics'])->name('admin.brands.analytics');

    // Products Management - Complete CRUD with Connections
    Route::resource('products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy'
    ]);

    // Additional Products Routes
    Route::post('products/bulk-action', [ProductController::class, 'bulkActions'])->name('admin.products.bulk');
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('admin.products.toggle');
    Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('admin.products.featured');

    // Product Connection Routes
    Route::get('products/{product}/reviews', [ProductController::class, 'reviews'])->name('admin.products.reviews');
    Route::get('products/{product}/orders', [ProductController::class, 'orders'])->name('admin.products.orders');
    Route::get('products/{product}/inventory', [ProductController::class, 'inventory'])->name('admin.products.inventory');
    Route::get('products/{product}/analytics', [ProductController::class, 'analytics'])->name('admin.products.analytics');


    // Attributes Management - Complete CRUD with Connections
    Route::resource('attributes', AttributeController::class)->names([
        'index' => 'admin.attributes.index',
        'create' => 'admin.attributes.create',
        'store' => 'admin.attributes.store',
        'show' => 'admin.attributes.show',
        'edit' => 'admin.attributes.edit',
        'update' => 'admin.attributes.update',
        'destroy' => 'admin.attributes.destroy'
    ]);

    // Additional Attributes Routes
    Route::post('attributes/bulk-action', [AttributeController::class, 'bulkActions'])->name('admin.attributes.bulk');

    // Attribute Connection Routes
    Route::get('attributes/{attribute}/values', [AttributeController::class, 'values'])->name('admin.attributes.values');
    Route::get('attributes/{attribute}/products', [AttributeController::class, 'products'])->name('admin.attributes.products');
    Route::get('attributes/{attribute}/contacts', [AttributeController::class, 'contacts'])->name('admin.attributes.contacts');
    Route::post('attributes/{attribute}/contacts', [AttributeController::class, 'storeContact'])->name('admin.attributes.contacts.store');
    Route::get('attributes/{attribute}/analytics', [AttributeController::class, 'analytics'])->name('admin.attributes.analytics');

    // Attribute Values Management - Complete CRUD System
    Route::resource('attributeValues', AttributeValuesController::class)->names([
        'index' => 'admin.attributeValues.index',
        'create' => 'admin.attributeValues.create',
        'store' => 'admin.attributeValues.store',
        'show' => 'admin.attributeValues.show',
        'edit' => 'admin.attributeValues.edit',
        'update' => 'admin.attributeValues.update',
        'destroy' => 'admin.attributeValues.destroy'
    ]);

    // Additional Attribute Values Routes
    Route::post('attributeValues/bulk-action', [AttributeValuesController::class, 'bulkActions'])->name('admin.attributeValues.bulk');
    Route::post('attributeValues/bulk-import', [AttributeValuesController::class, 'bulkImport'])->name('admin.attributeValues.import');
    Route::get('attributeValues/{attributeValue}/products', [AttributeValuesController::class, 'products'])->name('admin.attributeValues.products');

    // Product Attributes Management - Complete CRUD System
    Route::resource('productAttributes', ProductAttributesController::class)->names([
        'index' => 'admin.productAttributes.index',
        'create' => 'admin.productAttributes.create',
        'store' => 'admin.productAttributes.store',
        'show' => 'admin.productAttributes.show',
        'edit' => 'admin.productAttributes.edit',
        'update' => 'admin.productAttributes.update',
        'destroy' => 'admin.productAttributes.destroy'
    ]);

    // Additional Product Attributes Routes
    Route::post('productAttributes/bulk-action', [ProductAttributesController::class, 'bulkActions'])->name('admin.productAttributes.bulk');
    Route::post('productAttributes/bulk-assign', [ProductAttributesController::class, 'bulkAssign'])->name('admin.productAttributes.bulkAssign');
    Route::get('productAttributes/analytics/dashboard', [ProductAttributesController::class, 'analytics'])->name('admin.productAttributes.analytics');

    // Reviews Management - Complete CRUD System
    Route::resource('reviews', ReviewsController::class)->names([
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
    Route::get('reviews/{review}/contacts', [App\Http\Controllers\Admin\ReviewsController::class, 'contacts'])->name('admin.reviews.contacts');
    Route::post('reviews/{review}/contacts', [App\Http\Controllers\Admin\ReviewsController::class, 'storeContact'])->name('admin.reviews.contacts.store');

    // Sliders Management - Complete CRUD System
    Route::resource('sliders', SlidersController::class)->names([
        'index' => 'admin.sliders.index',
        'create' => 'admin.sliders.create',
        'store' => 'admin.sliders.store',
        'show' => 'admin.sliders.show',
        'edit' => 'admin.sliders.edit',
        'update' => 'admin.sliders.update',
        'destroy' => 'admin.sliders.destroy'
    ]);

    // Additional Sliders Routes
    Route::post('sliders/bulk-action', [SlidersController::class, 'bulkActions'])->name('admin.sliders.bulk');
    Route::patch('sliders/{slider}/toggle-status', [SlidersController::class, 'toggleStatus'])->name('admin.sliders.toggleStatus');
    Route::post('sliders/reorder', [SlidersController::class, 'reorder'])->name('admin.sliders.reorder');
    Route::get('sliders/analytics/dashboard', [SlidersController::class, 'analytics'])->name('admin.sliders.analytics');

    // Orders Management - Complete CRUD System
    Route::resource('orders', OrdersController::class)->names([
        'index' => 'admin.orders.index',
        'create' => 'admin.orders.create',
        'store' => 'admin.orders.store',
        'show' => 'admin.orders.show',
        'edit' => 'admin.orders.edit',
        'update' => 'admin.orders.update',
        'destroy' => 'admin.orders.destroy'
    ]);

    // Additional Orders Routes
    Route::post('orders/bulk-action', [OrdersController::class, 'bulkActions'])->name('admin.orders.bulk');
    Route::patch('orders/{order}/update-status', [OrdersController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('orders/{order}/update-payment-status', [OrdersController::class, 'updatePaymentStatus'])->name('admin.orders.updatePaymentStatus');
    Route::get('orders/analytics/dashboard', [OrdersController::class, 'analytics'])->name('admin.orders.analytics');

    // Order Items Management - Complete CRUD System
    Route::resource('orderItems', OrderItemsController::class)->names([
        'index' => 'admin.orderItems.index',
        'create' => 'admin.orderItems.create',
        'store' => 'admin.orderItems.store',
        'show' => 'admin.orderItems.show',
        'edit' => 'admin.orderItems.edit',
        'update' => 'admin.orderItems.update',
        'destroy' => 'admin.orderItems.destroy'
    ]);

    // Additional Order Items Routes
    Route::post('orderItems/bulk-action', [OrderItemsController::class, 'bulkActions'])->name('admin.orderItems.bulk');
    Route::get('orderItems/analytics/dashboard', [OrderItemsController::class, 'analytics'])->name('admin.orderItems.analytics');
    Route::get('orders/{order}/items', [OrderItemsController::class, 'getOrderItems'])->name('admin.orderItems.getOrderItems');
    Route::post('orderItems/calculate-total', [OrderItemsController::class, 'calculateItemTotal'])->name('admin.orderItems.calculateTotal');

    // Warehouses Management - Complete CRUD System
    Route::resource('warehouses', WarehousesController::class)->names([
        'index' => 'admin.warehouses.index',
        'create' => 'admin.warehouses.create',
        'store' => 'admin.warehouses.store',
        'show' => 'admin.warehouses.show',
        'edit' => 'admin.warehouses.edit',
        'update' => 'admin.warehouses.update',
        'destroy' => 'admin.warehouses.destroy'
    ]);

    // Additional Warehouses Routes
    Route::post('warehouses/bulk-action', [WarehousesController::class, 'bulkActions'])->name('admin.warehouses.bulk');
    Route::patch('warehouses/{warehouse}/toggle-status', [WarehousesController::class, 'toggleStatus'])->name('admin.warehouses.toggleStatus');
    Route::get('warehouses/{warehouse}/inventory', [WarehousesController::class, 'inventory'])->name('admin.warehouses.inventory');
    Route::get('warehouses/{warehouse}/contacts', [WarehousesController::class, 'contacts'])->name('admin.warehouses.contacts');
    Route::get('warehouses/{warehouse}/analytics', [WarehousesController::class, 'analytics'])->name('admin.warehouses.analytics');

    // Inventory Management - Complete CRUD System
    Route::resource('inventory', InventoryController::class)->names([
        'index' => 'admin.inventory.index',
        'create' => 'admin.inventory.create',
        'store' => 'admin.inventory.store',
        'show' => 'admin.inventory.show',
        'edit' => 'admin.inventory.edit',
        'update' => 'admin.inventory.update',
        'destroy' => 'admin.inventory.destroy'
    ]);

    // Additional Inventory Routes
    Route::post('inventory/bulk-action', [InventoryController::class, 'bulkActions'])->name('admin.inventory.bulk');
    Route::post('inventory/{inventory}/adjust-quantity', [InventoryController::class, 'adjustQuantity'])->name('admin.inventory.adjustQuantity');
    Route::get('inventory/analytics/dashboard', [InventoryController::class, 'analytics'])->name('admin.inventory.analytics');
    Route::get('inventory/data/get', [InventoryController::class, 'getInventoryData'])->name('admin.inventory.getData');

    // Transactions Management - Complete CRUD System
    Route::resource('transactions', TransactionsController::class)->names([
        'index' => 'admin.transactions.index',
        'create' => 'admin.transactions.create',
        'store' => 'admin.transactions.store',
        'show' => 'admin.transactions.show',
        'edit' => 'admin.transactions.edit',
        'update' => 'admin.transactions.update',
        'destroy' => 'admin.transactions.destroy'
    ]);

    // Additional Transactions Routes
    Route::post('transactions/bulk-action', [TransactionsController::class, 'bulkActions'])->name('admin.transactions.bulk');
    Route::patch('transactions/{transaction}/update-status', [TransactionsController::class, 'updateStatus'])->name('admin.transactions.updateStatus');
    Route::post('transactions/{transaction}/refund', [TransactionsController::class, 'processRefund'])->name('admin.transactions.refund');
    Route::get('transactions/analytics/dashboard', [TransactionsController::class, 'analytics'])->name('admin.transactions.analytics');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Add more admin routes here
});


// Frontend Functionality Routes
Route::get('/listing-grid-2-full', [FunctionController::class, 'listingGrid2Full'])->name('listing.grid2full');
// Route::get('/listing-grid-7-sidebar-right', [FunctionController::class, 'listingGrid7SidebarRight'])->name('listing.grid7sidebar');
Route::get('/listing-grid-1-full', [FunctionController::class, 'listingGrid1Full'])->name('listing.grid1full');
Route::get('/listing-grid-3', [FunctionController::class, 'listingGrid3'])->name('listing.grid3');
Route::get('/girls', [FunctionController::class, 'girls'])->name('listing.girls');

// Simple pages
Route::get('/product-detail-2', [FunctionController::class, 'productDetail2'])->name('frontend.product-detail-2');
Route::get('/cart', [FunctionController::class, 'cart'])->name('frontend.cart');
Route::get('/checkout', [FunctionController::class, 'checkout'])->name('frontend.checkout');
Route::get('/confirm', [FunctionController::class, 'confirm'])->name('frontend.confirm');
Route::get('/account', [FunctionController::class, 'account'])->name('frontend.account');
Route::get('/track-order', [FunctionController::class, 'trackOrder'])->name('frontend.track-order');
Route::get('/help', [FunctionController::class, 'help'])->name('frontend.help');
Route::get('/my-orders', [FunctionController::class, 'myOrders'])->name('frontend.my-orders');
Route::get('/profile-page', [FunctionController::class, 'profilePage'])->name('frontend.profile-page');
Route::get('/my-wishlist', [FunctionController::class, 'myWishlist'])->name('frontend.my-wishlist');

// Reviews
Route::get('/leave-review/{product?}', [ReviewController::class, 'show'])->name('frontend.leave-review');
Route::post('/leave-review', [ReviewController::class, 'store'])->name('frontend.review.store');





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
        