{{-- resources/views/admin/sessions.blade.php --}}
@extends('admin.dashboard')
@section('admin-content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Расписание сеансов</h1>
    <a href="{{ route('admin.sessions.create') }}" class="btn btn-primary">+ Добавить сеанс</a>
</div>
<div class="card">
    <table class="table">
        <thead><tr><th>Фильм</th><th>Зал</th><th>Дата и время</th><th>Цена</th><th></th></tr></thead>
        <tbody>
            @foreach($sessions as $session)
            <tr>
                <td>{{ $session->movie->title }}</td>
                <td>{{ $session->hall->name }}</td>
                <td>{{ \Carbon\Carbon::parse($session->start_time)->format('d.m.Y H:i') }}</td>
                <td>{{ number_format($session->price, 0, ',', ' ') }} ₽</td>
                <td><a href="{{ route('admin.sessions.edit', $session->id) }}" class="btn">✏️</a>
                    <a href="{{ route('admin.sessions.delete', $session->id) }}" class="btn btn-danger" onclick="return confirm('Удалить сеанс?')">🗑️</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sessions->links() }}
</div>
@endsection