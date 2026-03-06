<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books');

Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest')->name('login');
