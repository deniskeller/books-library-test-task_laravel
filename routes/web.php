<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->middleware('auth');

Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest')->name('login');

// Route::post('/login', function () {
//     return view('pages.login');
// });
