@extends('layouts.app')
@section('title', 'Сеансы')
@section('content')
<div class="container">
    <h1 class="text-3xl font-semibold mb-3">Сегодня в кинозале</h1>
    <p class="text-gray-400 mb-8">Выберите фильм и время</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($now_playing as $movie)
        <div class="card p-5">
            <div class="text-xl font-semibold mb-1">{{ $movie->title }}</div>
            <div class="text-sm text-gray-400 mb-3">{{ $movie->duration }} мин · {{ $movie->age_rating }}</div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-300">{{ $movie->release_date->format('d.m') }}</span>
                <a href="{{ route('movie.show', $movie->id) }}" class="text-sm border border-gray-500 rounded-full px-3 py-1 hover:bg-gray-800">Билеты</a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-8 text-center"><a href="{{ route('movies.index') }}" class="btn-outline inline-block">Вся афиша</a></div>
</div>
@endsection