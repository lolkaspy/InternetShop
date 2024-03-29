@php use App\Models\Cart; @endphp
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm bg-black-pastel sticky-top">
        <div class="container">
            <a class="navbar-brand text-white" href="{{route('main')}}">
                Главная</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="{{route('catalog')}}">Каталог</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{route('products.index')}}">Все
                            товары</a></li>
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('orders') }}">
                                Заказы пользователей
                            </a>
                        </li>
                    @endif
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Войти') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-white"
                                   href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                            </li>
                        @endif
                    @else
                        @if(Auth::check() && Auth::user()->role_id == 2)
                            <li class="nav-item">
                                <a class="text-white nav-link"
                                   href="{{route('cart.index')}}">Корзина({{Cart::where('user_id', Auth::id())->count()}})</a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white"
                               href="{{route('profile')}}" role="button" data-bs-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end text-white" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    Личный кабинет
                                </a>
                                @if(Auth::check() && Auth::user()->role_id == 2)
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        Заказы
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Выход') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="text-white nav-link">{{Auth::user()->balance}}</div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</div>
<hr>
<div class="container my-5">
    <footer class="text-center text-lg-start text-white fixed-bottom  bg-black-pastel">
        <div class="footer-left label-14pt align-middle">
            <p class="p-center">Личный интернет-магазин</p>
        </div>
        <div class="footer-right  d-flex justify-content-end">
            <a href="https://vk.com/belyashdima"><img src="/images/VK.png" alt="VK" class=" btn img-fluid"></a>
            <a href="https://t.me/belyashdima"><img src="/images/TG.png" alt="TELEGRAM" class="btn img-fluid"></a>
            <a href="https://discordapp.com/users/164427661635092480"><img src="/images/DS.png" alt="DISCORD"
                                                                           class="btn img-fluid"></a>
        </div>
    </footer>
</div>
</body>
</html>
