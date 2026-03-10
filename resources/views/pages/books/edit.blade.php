@extends('layouts.app')

@section('title', isset($book) ? 'Редактирование книги' : 'Добавление книги')

@section('content')
    <div class="row col-12 col-md-6">
        <h1><?= isset($book) ? 'Редактирование книги' : 'Добавление книги' ?></h1>

        <form method="POST" action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}">
            @csrf
            <!-- Для PUT запроса при редактировании -->
            @if (isset($book))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">Название книги</label>

                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title', $book->title ?? '') }}">

                @error('title')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Год издания</label>

                <input type="text" class="form-control @error('year') is-invalid @enderror" id="year" name="year"
                    value="{{ old('year', $book->year ?? '') }}">

                @error('year')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>

            @if ($authors->isNotEmpty())
                <div class="mb-3">
                    <label for="authors_ids" class="form-label">Авторы</label>

                    <select multiple class="form-control @error('authors_ids') is-invalid @enderror" id="authors_ids"
                        name="authors_ids[]" size="1">
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}"
                                {{ in_array($author->id, old('authors_ids', $selectedAuthorIds)) ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('authors_ids')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <button type="submit" class="btn btn-primary">
                {{ isset($book) ? 'Сохранить' : 'Добавить' }}
            </button>

            <a href="/books" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
