<?php

use Illuminate\Support\Facades\Route;

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

