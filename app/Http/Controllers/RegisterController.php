<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function show(): void
    {
        $title = 'Регистрация';
        View::render('register', compact('title'));
    }
}
