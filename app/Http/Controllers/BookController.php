<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BookController extends Controller
{
    // рендер страницы books
    public function index(Request $request): View
    {
        $authors = Author::all();
        $authorFilter = $request->input('book-filter-author');

        $perPage = config('settings.per_page');

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

    // запись новой книги в таблицу
    public function store(StoreBookRequest  $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $book = Book::create([
                'title' => $validated['title'],
                'year' => $validated['year']
            ]);

            $book->authors()->attach($validated['authors_ids']);

            return redirect()->route('books.index')
                ->with('success', 'Книга успешно добавлена');
        } catch (\Exception $e) {
            Log::error('[BookController::store] Ошибка при добавлении книги', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token')
            ]);

            return back()->withInput()->with([
                'error' => 'Ошибка при добавлении книги',
            ]);
        }
    }

    // рендер страницы редатирования книги
    public function edit($id): RedirectResponse|View
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')
                ->with('error', 'Книга не найдена');
        }

        $authors = Author::orderBy('name')->get();
        $selectedAuthorIds = $book->authors->pluck('id')->toArray();

        return view('pages.books.edit', [
            'book' => $book,
            'authors' => $authors,
            'selectedAuthorIds' => old('authors_ids', $selectedAuthorIds)
        ]);
    }

    // редактирование пданных книги
    public function update(StoreBookRequest $request, $id): RedirectResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')
                ->with('error', 'Книга не найдена');
        }

        $validated = $request->validated();

        try {
            $book->update([
                'title' => $validated['title'],
                'year' => $validated['year']
            ]);

            $book->authors()->sync($validated['authors_ids']);

            return redirect()->route('books.index')
                ->with('success', 'Книга успешно отредактирована');
        } catch (\Exception $e) {
            Log::error('[BookController::update] Ошибка при редактировании книги', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token')
            ]);

            return back()->withInput()->with([
                'error' => 'Ошибка при редактировании книги',
            ]);
        }
    }

    // удаление книги
    public function destroy(Request $request, $id): RedirectResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')
                ->with('error', 'Книга не найдена');
        }

        try {
            $book->authors()->detach();
            $book->delete();

            return redirect()->route('books.index')
                ->with('success', 'Книга успешно удалена');
        } catch (\Exception $e) {
            Log::error('[BookController::destroy] Ошибка при удалении книги', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token')
            ]);

            return back()->with([
                'error' => 'Ошибка при удалении книги',
            ]);
        }
    }
}
