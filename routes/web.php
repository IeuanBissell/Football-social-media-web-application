<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

// Fixtures Routes
Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');
Route::get('/fixtures/{fixture}', [FixtureController::class, 'show'])->name('fixtures.show');

// User Routes
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Posts Routes
Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

// Middleware to ensure only the user who created a post or a comment can edit it
Route::middleware(['auth'])->group(function () {
    // Edit Post (only for post author or user with the right role)
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('can:edit,post')->name('posts.edit'); 
    Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('can:edit,post')->name('posts.update'); 

    // Edit Comment (only for comment author or user with the right role)
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->middleware('can:edit,comment')->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->middleware('can:edit,comment')->name('comments.update');
    
    // Delete Post (only for post author or user with the right role)
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('can:delete,post')->name('posts.destroy');
    
    // Delete Comment (only for comment author or user with the right role)
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
