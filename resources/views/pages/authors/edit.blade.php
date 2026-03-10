@extends('layouts.app')

@section('title', isset($author) ? 'Редактирование автора' : 'Добавление автора')

@section('content')
    <div class="row col-12 col-md-6">
        <h1><?= isset($author) ? 'Редактирование автора' : 'Добавление автора' ?></h1>

        <form method="POST" action="{{ isset($author) ? route('authors.update', $author->id) : route('authors.store') }}">
            <!-- Для PUT запроса при редактировании -->
            @if (isset($author))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">ФИО</label>

                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $author->name ?? '') }}">

                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                {{ isset($author) ? 'Сохранить' : 'Добавить' }}
            </button>

            <a href="/authors" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
