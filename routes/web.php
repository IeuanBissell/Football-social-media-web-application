<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');
Route::get('/fixtures/{fixture}', [FixtureController::class, 'show'])->name('fixtures.show');
Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show'); // Using model binding

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Fixtures -> Posts (nested resource)
    Route::prefix('fixtures/{fixture}')->group(function () {
        // Create post
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

        // Edit, update, delete posts (with proper authorization)
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // Posts -> Comments (nested resource)
    Route::prefix('posts/{post}')->group(function () {
        Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
        Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    });

    // Comments Management
    Route::prefix('comments')->group(function () {
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
        Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });
});

// Include Auth Routes
require __DIR__.'/auth.php';
