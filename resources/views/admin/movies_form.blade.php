{{-- resources/views/admin/movies_form.blade.php --}}
@extends('admin.dashboard')
@section('admin-content')
<div class="card max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-4">{{ isset($movie) ? 'Редактировать фильм' : 'Новый фильм' }}</h1>
    <form method="POST" action="{{ isset($movie) ? route('admin.movies.update', $movie->id) : route('admin.movies.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group"><label>Название</label><input type="text" name="title" value="{{ $movie->title ?? '' }}" required></div>
        <div class="form-group"><label>Описание</label><textarea name="description" rows="5" required>{{ $movie->description ?? '' }}</textarea></div>
        <div class="form-row">
            <div class="form-group w-1/3"><label>Длительность (мин)</label><input type="number" name="duration" value="{{ $movie->duration ?? '' }}" required></div>
            <div class="form-group w-1/3"><label>Возрастной рейтинг</label><input type="text" name="age_rating" value="{{ $movie->age_rating ?? '12+' }}"></div>
            <div class="form-group w-1/3"><label>Дата выхода</label><input type="date" name="release_date" value="{{ isset($movie) && $movie->release_date ? $movie->release_date->format('Y-m-d') : '' }}"></div>
        </div>
        <div class="form-group"><label>Постер</label><input type="file" name="poster" accept="image/*">
            @if(isset($movie) && $movie->poster)
                <div class="mt-2"><img src="{{ asset('storage/' . $movie->poster) }}" style="max-height: 100px;"><label><input type="checkbox" name="delete_poster"> Удалить постер</label></div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.movies') }}" class="btn">Отмена</a>
    </form>
</div>
@endsection