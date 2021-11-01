<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{env('APP_CREATOR')}}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">

    <script defer src="assets/js/app.js"></script>
</head>

<body class="d-flex text-center">

    <div class="d-flex w-100 mx-auto flex-column">
        <header class="p-2 mb-auto border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="/" class="nav-link px-2 link-secondary">Главная</a></li>
                        <li><a href="#" class="nav-link px-2 link-dark">Контакты</a></li>
                        <li><a href="#" class="nav-link px-2 link-dark">Обо мне</a></li>
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                        <input type="search" class="form-control form-control-dark" placeholder="Поиск...">
                    </form>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-primary me-2">Войти</button>
                        <button type="button" class="btn btn-primary">Зарегистрироваться</button>
                    </div>
                </div>
            </div>
        </header>

        <main id="app" class="flex-grow-1 flex-center position-ref">
            @yield('content')
        </main>

        <footer class="mt-auto py-2 pt-3 border-top">
            <p class="text-center text-muted">© {{ now()->year }} {{ env('APP_CREATOR') }}</p>
        </footer>
    </div>
</body>

</html>