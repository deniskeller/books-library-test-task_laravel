<header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Books Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/books">Книги</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/authors">Авторы</a>
                    </li>
                </ul>

                <ul class="d-flex text-white gap-4 align-items-center list-unstyled m-0">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                    <li>
                        <div class="">логин: <?php echo $_SESSION['user_name']; ?></div>
                        <div class="">роль: <?php echo $_SESSION['user_role']; ?></div>
                    </li>
                    <li>
                        <form action="/logout" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Уверены что хотите выйти из профиля?')">Выход
                            </button>
                        </form>
                        <!-- <a class="nav-link" href="/logout">Выход</a> -->
                    </li>
                    <?php else : ?>
                    <li><a class="nav-link" href="/login">Вход</a></li>
                    <li><a class="nav-link" href="/register">Регистрация</a></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
