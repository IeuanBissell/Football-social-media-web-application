<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware('auth');
Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read')->middleware('auth');


Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');
Route::get('/fixtures/{id}', [FixtureController::class, 'show'])->name('fixtures.show');


Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');


Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('can:edit,post')->name('posts.edit'); 
    Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('can:edit,post')->name('posts.update'); 
    
    Route::post('/fixtures/{id}/posts', [PostController::class,'store'])->name('posts.store');
    
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->middleware('can:edit,comment')->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->middleware('can:edit,comment')->name('comments.update');
    
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('can:delete,post')->name('posts.destroy');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->middleware('can:delete,comment')->name('comments.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

Route::get('/notifications', function () {
    return view('notifications.index', [
        'notifications' => Auth::user()->notifications,
    ]);
})->middleware('auth');