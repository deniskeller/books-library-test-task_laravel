<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/books', function () {
    return view('pages.books.index');
    // echo 'страница books index';
})->name('books');

Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest')->name('login');

// Route::post('/login', function () {
//     return view('pages.login');
// });
