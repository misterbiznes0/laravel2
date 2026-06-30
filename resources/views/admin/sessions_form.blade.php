{{-- resources/views/admin/sessions_form.blade.php --}}
@extends('admin.dashboard')
@section('admin-content')
<div class="card max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-4">{{ isset($session) ? 'Редактировать сеанс' : 'Добавить сеанс' }}</h1>
    <form method="POST" action="{{ isset($session) ? route('admin.sessions.update', $session->id) : route('admin.sessions.store') }}">
        @csrf
        <div class="form-group"><label>Фильм</label>
            <select name="movie_id" required>
                @foreach($movies as $movie)
                <option value="{{ $movie->id }}" {{ isset($session) && $session->movie_id == $movie->id ? 'selected' : '' }}>{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Зал</label>
            <select name="hall_id" required>
                @foreach($halls as $hall)
                <option value="{{ $hall->id }}" {{ isset($session) && $session->hall_id == $hall->id ? 'selected' : '' }}>{{ $hall->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Дата и время начала</label><input type="datetime-local" name="start_time" value="{{ isset($session) ? \Carbon\Carbon::parse($session->start_time)->format('Y-m-d\TH:i') : '' }}" required></div>
        <div class="form-group"><label>Цена</label><input type="number" name="price" value="{{ $session->price ?? 300 }}" step="50"></div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.sessions') }}" class="btn">Отмена</a>
    </form>
</div>
@endsection