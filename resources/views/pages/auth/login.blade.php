@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <form class="col-12 col-md-6" method="POST" action="{{ route('login') }}">
        @csrf
        <h1 class="fs-2">Вход</h1>

        <div class="mb-3">
            <label for="username" class="form-label">Логин</label>

            <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}"
                @error('username') is-invalid @enderror">

            @error('username')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>

            <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}"
                @error('password') is-invalid @enderror">

            @error('password')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>

        <a class="ml-2" href="/">На главную</a>
    </form>
@endsection
