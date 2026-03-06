<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $authors = Author::all();
        $authorFilter = $request->input('book-filter-author');

        $perPage = 5;
        $paginator = Book::paginate($perPage);

        $query = Book::query();
        if ($authorFilter) {
            $query->whereHas('authors', function ($q) use ($authorFilter) {
                $q->where('authors.id', $authorFilter);
            });
        }
        $books = $query->with('authors')->paginate($perPage)->withQueryString();


        // dump($books->lastPage());

        return view('pages.books.index', [
            'books' => $books,
            'authors' => $authors,
            'authorFilter' => $authorFilter,
            'paginator' => $paginator,
        ]);
    }
}
