<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\NoHtmlTags;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show(): View
    {
        return view('pages.auth.register');
    }
}
