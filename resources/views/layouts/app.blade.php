<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Аптека')</title>
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    @stack('styles')
</head>
<body>
    <div class="container">
        <header>
            <div class="header-top">
                <h1>PHARMA</h1>
                <form action="{{ route('medicines.index') }}" method="GET" class="search-box">
                    <input type="text" name="search" placeholder="Поиск лекарств..." value="{{ request('search') }}">
                    <button type="submit">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <circle cx="9" cy="9" r="6" stroke="currentColor" stroke-width="2"/>
                            <path d="M13 13L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </form>
                <nav>
                    <a href="{{ route('home') }}">Главная</a>
                    <a href="{{ route('medicines.index') }}">Каталог</a>
                    @auth
                        <span>{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="padding: 10px 20px;">Выйти</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Вход</a>
                        <a href="{{ route('register') }}">Регистрация</a>
                    @endauth
                </nav>
            </div>
        </header>

        <div class="content">
            @yield('content')
        </div>

        <footer class="site-footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>PHARMA</h3>
                    <p>Ваше здоровье — наш приоритет. Качественные препараты по доступным ценам.</p>
                </div>
                <div class="footer-section">
                    <h4>Навигация</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('medicines.index') }}">Каталог</a></li>
                        @auth
                        @else
                            <li><a href="{{ route('login') }}">Вход</a></li>
                            <li><a href="{{ route('register') }}">Регистрация</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Контакты</h4>
                    <ul>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3 2H13C13.5523 2 14 2.44772 14 3V13C14 13.5523 13.5523 14 13 14H3C2.44772 14 2 13.5523 2 13V3C2 2.44772 2.44772 2 3 2Z" stroke="var(--gold)" stroke-width="1.5"/>
                                <path d="M2 4L8 8L14 4" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            info@pharma.ru
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3 2H5.5C6.32843 2 7 2.67157 7 3.5V3.5C7 4.32843 6.32843 5 5.5 5H3M3 11H5.5C6.32843 11 7 11.6716 7 12.5V12.5C7 13.3284 6.32843 14 5.5 14H3M11 3H13C13.5523 3 14 3.44772 14 4V4C14 4.55228 13.5523 5 13 5H11M11 11H13C13.5523 11 14 11.4477 14 12V12C14 12.5523 13.5523 13 13 13H11" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            +7 (999) 123-45-67
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 1C10.7614 1 13 3.23858 13 6C13 9.5 8 15 8 15C8 15 3 9.5 3 6C3 3.23858 5.23858 1 8 1Z" stroke="var(--gold)" stroke-width="1.5"/>
                                <circle cx="8" cy="6" r="1.5" fill="var(--gold)"/>
                            </svg>
                            г. Москва, ул. Примерная, 1
                        </li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Режим работы</h4>
                    <ul>
                        <li>Пн-Пт: 9:00 - 21:00</li>
                        <li>Сб-Вс: 10:00 - 20:00</li>
                        <li>Доставка: 24/7</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-copyright">
                    <p>&copy; {{ date('Y') }} PHARMA. Все права защищены.</p>
                </div>
                <div class="footer-links">
                    <a href="#">Политика конфиденциальности</a>
                    <a href="#">Условия использования</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
