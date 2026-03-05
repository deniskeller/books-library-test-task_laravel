@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <form class="col-12 col-md-6" method="POST" action="/login">
        <h1 class="fs-2">Вход</h1>

        <div class="mb-3">
            <label for="username" class="form-label">Логин</label>
            <input type="text" class="form-control" name="username" id="username" aria-describedby="usernameHelp">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="text" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
        <a class="ml-2" href="/">На главную</a>
    </form>
@endsection
