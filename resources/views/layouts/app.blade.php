<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Кинотеатр')</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0c12; color: #eef2ff; font-family: 'Inter', system-ui, sans-serif; line-height: 1.5; display: flex; flex-direction: column; min-height: 100vh; }
        main { flex: 1; }
        
        /* Шапка */
        .top-bar { background: #11141c; border-bottom: 1px solid #232836; padding: 1rem 2rem; position: sticky; top: 0; z-index: 30; }
        .top-bar-inner { max-width: 1280px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; }
        .logo { font-size: 1.5rem; font-weight: 700; color: #eef2ff; text-decoration: none; letter-spacing: -0.3px; }
        .nav { display: flex; flex-wrap: wrap; gap: 1.8rem; }
        .nav a { color: #9aa4bf; text-decoration: none; transition: 0.2s; font-weight: 500; }
        .nav a:hover, .nav .active { color: #ffffff; }
        
        /* Кнопки */
        .btn-outline { background: none; border: 1px solid #2d3748; color: #eef2ff; padding: 0.4rem 1rem; border-radius: 2rem; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn-outline:hover { background: #2d3748; }
        .btn-solid { background: #2d3748; border: none; color: white; padding: 0.4rem 1.2rem; border-radius: 2rem; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn-solid:hover { background: #3b455e; }
        .btn-admin { background: #1f2a3a; color: #eef2ff; padding: 0.2rem 0.8rem; border-radius: 2rem; font-size: 0.75rem; text-decoration: none; display: inline-block; }
        
        /* Контейнер */
        .container { max-width: 1280px; margin: 0 auto; padding: 2rem 1.5rem; }
        
        /* Карточки */
        .card { background: #11141c; border: 1px solid #232836; border-radius: 1.25rem; transition: 0.2s; }
        .card:hover { border-color: #3b455e; transform: translateY(-2px); }
        
        /* Цвета мест */
        .seat-free { background: #2d3748; border: 1px solid #4a5568; color: #e2e8f0; }
        .seat-vip { background: #d97706; border: 1px solid #f59e0b; color: white; font-weight: bold; }
        .seat-selected { background: #10b981 !important; border: 1px solid #34d399; color: white; box-shadow: 0 0 0 1px #10b981; }
        .seat-booked { background: #991b1b !important; border: 1px solid #ef4444; color: #9ca3af; text-decoration: line-through; cursor: not-allowed; opacity: 0.7; }
        
        /* Футер */
        .footer { background: #0b0e15; border-top: 1px solid #181e28; padding: 2rem 2rem 1.5rem; margin-top: 2rem; }
        .footer-grid { max-width: 1280px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 2rem; justify-content: space-between; }
        .footer-col h4 { color: #cbd5e6; margin-bottom: 0.8rem; font-size: 1rem; font-weight: 500; }
        .footer-col p, .footer-col a { color: #6e768f; text-decoration: none; display: block; margin-bottom: 0.4rem; font-size: 0.85rem; }
        .footer-col a:hover { color: #eef2ff; }
        .footer-copy { text-align: center; font-size: 0.7rem; color: #4b5568; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #181e28; }
        
        @media (max-width: 760px) {
            .top-bar-inner { flex-direction: column; align-items: stretch; text-align: center; }
            .nav { justify-content: center; }
            .footer-grid { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="top-bar-inner">
            <a href="/" class="logo">Кинозал</a>
            <div class="nav">
                <a href="/" class="{{ request()->routeIs('home') ? 'active' : '' }}">Сеансы</a>
                <a href="{{ route('movies.index') }}" class="{{ request()->routeIs('movies.*') ? 'active' : '' }}">Афиша</a>
                <a href="{{ route('schedule') }}" class="{{ request()->routeIs('schedule') ? 'active' : '' }}">Расписание</a>
                @auth
                <a href="{{ route('bookings.history') }}">Билеты</a>
                @endauth
            </div>
            <div>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="/admin" class="btn-admin">Админка</a>
                    @endif
                    <form method="POST" action="/logout" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-outline" style="font-size:0.8rem;">Выйти</button>
                    </form>
                @else
                    <a href="/login" class="btn-outline">Вход</a>
                    <a href="/register" class="btn-solid">Регистрация</a>
                @endauth
            </div>
        </div>
    </div>

    <main>@yield('content')</main>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col"><h4>Кинозал</h4><p>Уютные залы, отличный звук</p></div>
            <div class="footer-col"><h4>Контакты</h4><a href="mailto:info@kinospace.ru">info@kinospace.ru</a></div>
            <div class="footer-col"><h4>Навигация</h4><a href="/">Сеансы</a><a href="/movies">Афиша</a><a href="/schedule">Расписание</a>@auth<a href="/bookings/history">Билеты</a>@endauth</div>
        </div>
        <div class="footer-copy">Кинозал · 2026</div>
    </footer>
</body>
</html>