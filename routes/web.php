<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function(){
    return "The home page";
});

Route::get('/food', function () {
    return view('food');
});