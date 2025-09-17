<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('index-2');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (protected by auth and admin middleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Add more admin routes here
});

Route::get('/listing-grid-2-full', function () {
    return view('listing-grid-2-full');
});

Route::get('/listing-grid-7-sidebar-right', function () {
    return view('listing-grid-7-sidebar-right');
});

Route::get('/listing-grid-1-full', function () {
    return view('listing-grid-1-full');
});

Route::get('/listing-grid-3', function () {
    return view('listing-grid-3');
});

Route::get('/girls', function () {
    return view('Girls');
});

Route::get('/product-detail-2', function () {
    return view('product-detail-2');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/confirm', function () {
    return view('confirm');
});

Route::get('/account', function () {
    return view('account');
});

Route::get('/track-order', function () {
    return view('track-order');
});

Route::get('/help', function () {
    return view('help');
});

Route::get('/leave-review', function () {
    return view('leave-review');
});

Route::get('/my-orders', function () {
    return view('my-orders');
});

Route::get('/profile-page', function () {
    return view('profile-page');
});

Route::get('/my-wishlist', function () {
    return view('my-wishlist');
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

