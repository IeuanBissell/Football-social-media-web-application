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
Route::get('/fixtures/{id}', [FixtureController::class, 'show'])->name('fixtures.show');
Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');

// Notifications Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Posts Management
    Route::prefix('posts')->group(function () {
        Route::post('/fixtures/{fixture}/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/fixtures/{fixture_id}/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/fixtures/{fixture_id}/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/fixtures/{fixture_id}/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // Comments Management
    Route::prefix('comments')->group(function () {
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->middleware('can:edit,comment')->name('comments.edit');
        Route::put('/{comment}', [CommentController::class, 'update'])->middleware('can:edit,comment')->name('comments.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->middleware('can:delete,comment')->name('comments.destroy');
    });

    // Posts and Comments Association
    Route::prefix('posts/{post}')->group(function () {
        Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
        Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    });
});

// Include Auth Routes
require __DIR__.'/auth.php';
