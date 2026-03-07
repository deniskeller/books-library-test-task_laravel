<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    // рендер страницы books
    public function index(Request $request): View
    {
        $authors = Author::all();
        $authorFilter = $request->input('book-filter-author');

        $perPage = 5;
        // $paginator = Book::paginate($perPage);

        $query = Book::query();
        if ($authorFilter) {
            $query->whereHas('authors', function ($q) use ($authorFilter) {
                $q->where('authors.id', $authorFilter);
            });
        }
        $books = $query->with('authors')->paginate($perPage)->withQueryString();

        return view('pages.books.index', compact('books', 'authors', 'authorFilter'));
    }

    // рендер страницы создания книги
    public function create(): View
    {
        $authors = Author::orderBy('name')->get();

        return view('pages.books.edit', [
            'book' => null,
            'authors' => $authors,
            'selectedAuthorIds' => []
        ]);
    }

    // рендер страницы редатирования книги
    public function edit($id): View
    {
        return view('pages.books.edit');
    }

    // редактирование пданных книги
    public function update(): void {}

    // запись новой книги в таблицу
    public function store(Request $request): void
    {
        $input = $request->input();
        dump($input);
    }

    // удаление книги
    public function destroy($id): void {}
}
