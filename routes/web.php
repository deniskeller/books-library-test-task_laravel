<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/login', function () {
    return view('pages.login');
});

Route::post('/login', function () {
    return view('pages.login');
});
