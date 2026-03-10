<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest')->name('login');

Route::get('/books', [BookController::class, 'index'])->name('books.index'); // страница книг
Route::get('/books/create', [BookController::class, 'create'])->name('books.create'); // страница создания новой книги
Route::post('/books', [BookController::class, 'store'])->name('books.store'); // сохранение новой книги
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit'); // страница редактирования книги
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update'); // сохранение отредактированной книги
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy'); // удаления книги
