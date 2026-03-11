<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\NoHtmlTags;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function show(): View
    {
        return view('pages.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:2', 'max:60', 'unique:users', new NoHtmlTags('логин')],
            'password' => ['required', 'string', 'min:8', 'max:60', new NoHtmlTags('пароль')],
        ], [
            'username.unique' => 'Пользователь с таким логином уже существует',
            'username.required' => 'Поле обязательно для заполнения',
            'username.min' => 'Поле логина должно состоять минимум из 2 символов',
            'username.max' => 'Поле логина должно состоять максимум из 60 символов',
            'password.required' => 'Поле обязательно для заполнения',
            'password.min' => 'Поле пароля должно состоять минимум из 8 символов',
            'password.max' => 'Поле пароля должно состоять максимум из 60 символов',
        ]);

        try {
            $user = User::create([
                'username' => $validated['username'],
                'password_hash' => Hash::make($validated['password']),
                'user_role' => 'user'
            ]);

            Auth::login($user);

            return redirect()->route('welcome')
                ->with('success', 'Вы успешно зарегистрировались');
        } catch (\Exception $e) {
            Log::error('[RegisterController::register] Ошибка при регистрации', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token')
            ]);

            return back()->withInput()->with([
                'error' => 'Ошибка при регистрации',
            ]);
        }
    }
}
