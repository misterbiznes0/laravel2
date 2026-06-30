{{-- resources/views/admin/movies.blade.php --}}
@extends('admin.dashboard')
@section('admin-content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Фильмы</h1>
    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">+ Добавить фильм</a>
</div>
<div class="card">
    <table class="table">
        <thead>
            <tr><th>Название</th><th>Длительность</th><th>Возраст</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
            <tr>
                <td>{{ $movie->title }}</td>
                <td>{{ $movie->duration }} мин</td>
                <td>{{ $movie->age_rating }}</td>
                <td><a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn">✏️</a>
                    <a href="{{ route('admin.movies.delete', $movie->id) }}" class="btn btn-danger" onclick="return confirm('Удалить?')">🗑️</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $movies->links() }}
</div>
@endsection