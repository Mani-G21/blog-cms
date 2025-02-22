<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('admin/categories', [\App\Http\Controllers\admin\CategoriesController::class, 'index']);
