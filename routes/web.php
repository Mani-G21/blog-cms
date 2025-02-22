<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('admin/categories', [\App\Http\Controllers\admin\CategoriesController::class, 'index'])->name('admin.categories.index');
Route::get('admin/categories/create', [\App\Http\Controllers\admin\CategoriesController::class, 'create'])->name('admin.categories.create');
Route::post('admin/categories', [\App\Http\Controllers\admin\CategoriesController::class, 'store'])->name('admin.categories.store');
