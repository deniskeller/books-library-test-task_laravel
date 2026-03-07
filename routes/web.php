<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.edit');

Route::get('/books/edit', function () {
    return 'страница редактирования книги';
})->name('books.edit');

Route::get('/books/destroy', function () {
    return 'страница удаления книги';
})->name('books.destroy');

Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest')->name('login');
