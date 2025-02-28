<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\BlogsController::class, 'blogs'])->name('frontend.home');
Route::get('/blogs/{slug}', [\App\Http\Controllers\BlogsController::class, 'show'])->name('frontend.show');


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('tags', \App\Http\Controllers\admin\TagsController::class)->except(['show']);
    Route::resource('posts', \App\Http\Controllers\admin\PostsController::class);
    Route::resource('users', \App\Http\Controllers\admin\UsersController::class);
    Route::get('categories', [\App\Http\Controllers\admin\CategoriesController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [\App\Http\Controllers\admin\CategoriesController::class, 'create'])->name('categories.create');
    Route::post('categories', [\App\Http\Controllers\admin\CategoriesController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [\App\Http\Controllers\admin\CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [\App\Http\Controllers\admin\CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [\App\Http\Controllers\admin\CategoriesController::class, 'destroy'])->name('categories.destroy');

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    });
});

Auth::routes();
