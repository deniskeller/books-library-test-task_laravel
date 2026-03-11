<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// роуты книг
Route::get('/books', [BookController::class, 'index'])->name('books.index'); // страница книг
Route::get('/books/create', [BookController::class, 'create'])->name('books.create'); // страница создания новой книги
Route::post('/books', [BookController::class, 'store'])->name('books.store'); // сохранение новой книги
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit'); // страница редактирования книги
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update'); // сохранение отредактированной книги
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy'); // удаления книги

Route::get('books/{book}/category/{category}', [BookController::class, 'show']); // тестовый роут для нескольких параметров

// роуты авторов
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index'); // страница авторов
Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create'); // страница создания новой авторов
Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store'); // сохранение новой авторов
Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit'); // страница редактирования авторов
Route::put('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update'); // сохранение отредактированной авторов
Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy'); // удаления автора
