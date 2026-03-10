@extends('layouts.app')

@section('title', 'Авторы')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                @if ($authors->isNotEmpty())
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>ФИО</th>
                                <th>Количество книг</th>
                                <th>Действия</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($authors as $index => $author)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $author->name }}</td>
                                    <td>{{ $author->books_count ?? $author->book_counter }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('authors.edit', $author->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Редактировать
                                            </a>

                                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST"
                                                class="d-inline delete-form" data-author-name="{{ $author->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="emtry">Список авторов пуст</div>
                @endif
            </div>
        </div>
    </div>

    @if ($authors->hasPages())
        <nav aria-label="Пагинация" class="mt-4">
            {{ $authors->withQueryString()->links('pagination::bootstrap-5') }}
        </nav>
    @endif

    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('authors.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Добавить нового автора
            </a>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const authorName = this.dataset.authorName;
                if (confirm(`Уверены что хотите удалить автора "${authorName}"?`)) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
