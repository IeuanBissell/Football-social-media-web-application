<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function(){
    return view('home');
});

Route::get('/food', function () {
    return view('food');
});

Route::get('/users',[UserController::class, 'index'])->name('users.index');;