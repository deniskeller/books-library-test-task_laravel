<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    // рендер страницы авторов
    public function index(Request $request): View
    {
        $perPage = config('settings.per_page');
        $authors = Author::withCount('books')->paginate($perPage);

        return view('pages.authors.index', compact('authors'));
    }

    public function create(): View
    {
        return view('pages.authors.edit', ['author' => null]);
    }

    public function store(StoreAuthorRequest  $request): RedirectResponse
    {
        $validated = $request->validated();
        dd($validated);

        try {
            Author::create([
                'name' => $validated['name']
            ]);

            return redirect()->route('authors.index')
                ->with('success', 'Автор успешно добавлен');
        } catch (\Exception $e) {
            Log::error('[AuthorController::store] Ошибка при добавлении автора', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token')
            ]);

            return back()->withInput()->with([
                'error' => 'Ошибка при добавлении автора',
            ]);
        }
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return redirect()->route('authors.index')
                ->with('error', 'Автор не найден');
        }

        try {
            $author->books()->detach();
            $author->delete();

            return redirect()->route('authors.index')
                ->with('success', 'Автор успешно удален');
        } catch (\Exception $e) {
            Log::error('[AuthorController::destroy] Ошибка при удалении автора', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token')
            ]);

            return back()->with([
                'error' => 'Ошибка при удалении автора',
            ]);
        }
    }
}
