{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0c12; color: #eef2ff; font-family: 'Inter', system-ui, sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #11141c; border-right: 1px solid #232836; padding: 2rem 1rem; }
        .sidebar a { display: block; padding: 0.5rem 1rem; color: #9aa4bf; text-decoration: none; border-radius: 0.5rem; margin-bottom: 0.25rem; }
        .sidebar a:hover, .sidebar a.active { background: #1e293b; color: white; }
        .content { flex: 1; padding: 2rem; }
        .btn { padding: 0.4rem 1rem; border-radius: 0.5rem; background: #2d3748; color: white; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #2563eb; }
        .btn-danger { background: #dc2626; }
        .btn-warning { background: #d97706; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #232836; }
        .card { background: #11141c; border: 1px solid #232836; border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem; }
        input, select, textarea { background: #1e293b; border: 1px solid #334155; color: white; padding: 0.5rem; border-radius: 0.5rem; width: 100%; }
        .form-group { margin-bottom: 1rem; }
        .form-row { display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap; }
        .time-slot { background: #1e293b; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar">
            <div class="text-xl font-bold mb-6">Админ</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('admin.movies') }}" class="{{ request()->routeIs('admin.movies*') ? 'active' : '' }}">Фильмы</a>
            <a href="{{ route('admin.halls') }}" class="{{ request()->routeIs('admin.halls*') ? 'active' : '' }}">Залы</a>
            <a href="{{ route('admin.sessions') }}" class="{{ request()->routeIs('admin.sessions*') ? 'active' : '' }}">Расписание</a>
            <a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">Брони</a>
            <a href="/" class="mt-4 text-gray-500">На сайт</a>
        </div>
        <div class="content">
            @yield('admin-content')
        </div>
    </div>
</body>
</html>