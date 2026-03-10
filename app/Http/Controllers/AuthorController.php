<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthorController extends Controller
{
    // рендер страницы авторов
    public function index(Request $request): RedirectResponse|View
    {
        $perPage = config('settings.per_page');
        // $authors = Author::paginate($perPage);
        $authors = Author::withCount('books')->paginate($perPage);

        if ($authors->isEmpty()) {
            session()->now('error', 'Не удалось загрузить список авторов');
        }

        return view('pages.authors.index', compact('authors'));
    }

    public function destroy($id): void
    {
        dump($id);
    }
}
