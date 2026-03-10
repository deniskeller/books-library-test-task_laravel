<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

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

    public function destroy(Request $request, $id): RedirectResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return redirect()->route('authors.index')
                ->with('error', 'Автор не найдена');
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
