<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FixtureController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function(){
    return view('home');
});

Route::get('/food', function () {
    return view('food');
});

Route::get('/users',[UserController::class, 'index'])->name('users.index');

Route::get('/fixtures',[FixtureController::class,'index'])->name('fixtures.index');

Route::get('/fixtures/{id}',[FixtureController::class, 'show'])->name('fixtures.show');