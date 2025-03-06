<?php

use App\Http\Controllers\admin\PostsController;
use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;

Route::post('/posts/{token}/generate-ai', [\App\Http\Controllers\admin\PostsController::class, 'generateAI'])->name('admin.posts.generateAI'); // TODO: Add middleware auth so this route is protected after REST project
Route::post('/posts/upload-image', [PostsController::class, 'uploadImage'])->name('posts.uploadImage');
Route::post('/comment/validate-ai', [CommentsController::class, 'validateAI'])
    ->name('comments.validateAI');
