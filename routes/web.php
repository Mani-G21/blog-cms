<?php

use Illuminate\Support\Facades\Route;
Route::get('/', [\App\Http\Controllers\BlogsController::class, 'blogs'])->name('frontend.home');
Route::get('/blogs/{slug}', [\App\Http\Controllers\BlogsController::class, 'show'])->name('frontend.singleBlog');


Route::prefix('admin')->name('admin.')->group(function(){
    Route::resource('tags', \App\Http\Controllers\admin\TagsController::class)->except(['show']);
    Route::resource('posts', \App\Http\Controllers\admin\PostsController::class);
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});



Route::get('admin/categories', [\App\Http\Controllers\admin\CategoriesController::class, 'index'])->name('admin.categories.index');
Route::get('admin/categories/create', [\App\Http\Controllers\admin\CategoriesController::class, 'create'])->name('admin.categories.create');
Route::post('admin/categories', [\App\Http\Controllers\admin\CategoriesController::class, 'store'])->name('admin.categories.store');
Route::get('admin/categories/{category}/edit', [\App\Http\Controllers\admin\CategoriesController::class, 'edit'])->name('admin.categories.edit');
Route::put('admin/categories/{category}', [\App\Http\Controllers\admin\CategoriesController::class, 'update'])->name('admin.categories.update');
Route::delete('admin/categories/{category}', [\App\Http\Controllers\admin\CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
