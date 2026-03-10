<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index'); // страница книг
Route::get('/books/create', [BookController::class, 'create'])->name('books.create'); // страница создания новой книги
Route::post('/books', [BookController::class, 'store'])->name('books.store'); // сохранение новой книги
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit'); // страница редактирования книги
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update'); // сохранение отредактированной книги

Route::get('/books/edit', function () {
    return 'страница редактирования книги';
})->name('books.edit');

Route::get('/books/destroy', function () {
    return 'страница удаления книги';
})->name('books.destroy');

Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest')->name('login');
