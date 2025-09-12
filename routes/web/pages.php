<?php

use Illuminate\Support\Facades\Route;

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

