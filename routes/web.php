<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return '<h1>Test Page</h1>';
});

Route::resource('products', ProductController::class);
