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
Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');

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

    // Notification routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::patch('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read.all');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/delete-all', [NotificationController::class, 'destroyAll'])->name('destroy.all');
    });

    // API route for getting unread notification count (for AJAX requests)
    Route::get('/api/notifications/count', [NotificationController::class, 'getUnreadCount'])->name('notifications.count');
    Route::get('/api/users/search', function (Illuminate\Http\Request $request) {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = App\Models\User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    })->middleware('auth')->name('api.users.search');
});

// Include Auth Routes
require __DIR__.'/auth.php';
