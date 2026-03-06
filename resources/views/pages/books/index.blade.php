@extends('layouts.app')

@section('title', 'Книги')

@section('content')
    <div class="row mb-40">
        <div class="col-md-8 col-lg-9">
            <form class="row g-3">
                <div class="col-md-8">
                    <label for="authorFilter" class="form-label">Фильтр по автору</label>

                    <select id="authorFilter" name="book-filter-author" class="form-select">
                        <option selected value="">Все авторы</option>
                        <?php if (!empty($authors)) : ?>
                        <?php foreach ($authors as $author) : ?>
                        <option value="<?= $author['id'] ?>"><?= htmlspecialchars($author['name']) ?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        Применить фильтр
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <?php if (!empty($books)) : ?>
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Название книги</th>
                            <th>Автор(ы)</th>
                            <th>Год издания</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $index => $book) : ?>
                        <tr>
                            <th>{{ $books->firstItem() + $index }}</th>
                            <td><?= $book['title'] ?></td>
                            <td>{{ !empty($book->authors) ? $book->authors->pluck('name')->implode(', ') : 'Нет авторов' }}
                            </td>
                            <td><?= $book['year'] ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="/books/<?= $book['id'] ?>/edit" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Редактировать
                                    </a>
                                    <form action="/books/<?= $book['id'] ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Удалить эту книгу?')">
                                            <i class="bi bi-trash"></i> Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else : ?>
                <div class="emtry">Список книг пуст</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($books->total() > 1): ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $books->onFirstPage() ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $books->previousPageUrl() ?? '#' ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $books->lastPage(); $i++): ?>
            <li class="page-item <?= $books->currentPage() == $i ? 'active' : '' ?>">
                <?php if ($authorFilter) : ?>
                <a class="page-link"
                    href="?book-filter-author={{ $authorFilter }}&page={{ $i }}">{{ $i }}</a>
                <?php else : ?>
                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                <?php endif; ?>
            </li>
            <?php endfor; ?>

            <li class="page-item <?= !$books->hasMorePages() ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $books->nextPageUrl() ?? '#' ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-12">
            <a href="books/create" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Добавить новую книгу
            </a>
        </div>
    </div>
@endsection
