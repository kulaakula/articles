<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>@yield('title')</title>
</head>
<body class="d-flex flex-column min-vh-100">
<header class="mb-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light ps-5">
        <a class="navbar-brand " href="/">Блог</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contacts">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/comment/new">Новые комментарии</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/register">Регистрация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login">Войти</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                           aria-expanded="false">
                            Уведомления <span>{{auth()->user()->unreadNotifications()->count()}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(auth()->user()->unreadNotifications as $notification)
                                <li><a class="dropdown-item"
                                       href="/articles/{{$notification->data['article']['id']}}?notify={{$notification->id}}">{{$notification->data['article']['name']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/logout">Выйти</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/articles/create">Создать новость</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="ms-5">
    @yield('content')
</div>
<div id="app">
    <App></App>
</div>
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
<footer class="ms-5 mt-auto">Кулакова Екатерина, 211-323</footer>
</html>
