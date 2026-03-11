<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\NoHtmlTags;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('pages.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:2', 'max:60', new NoHtmlTags('логин')],
            'password' => ['required', 'string', 'min:8', 'max:60', new NoHtmlTags('пароль')],
        ], [
            'username.required' => 'Поле обязательно для заполнения',
            'username.min' => 'Поле логина должно состоять минимум из 2 символов',
            'username.max' => 'Поле логина должно состоять максимум из 60 символов',
            'password.required' => 'Поле обязательно для заполнения',
            'password.min' => 'Поле пароля должно состоять минимум из 8 символов',
            'password.max' => 'Поле пароля должно состоять максимум из 60 символов',
        ]);

        if (Auth::attempt([
            'username' => $validated['username'],
            'password' => $validated['password']
        ])) {
            $request->session()->regenerate();

            return redirect()->intended(route('books.index'))
                ->with('success', 'Вы успешно авторизовались');
        }

        return back()->with([
            'error' => 'Неверный логин или пароль.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Вы успешно вышли из системы');
    }
}
