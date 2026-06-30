{{-- resources/views/movies/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Афиша')

@section('content')
<div class="container">
    <h1 class="text-3xl font-semibold mb-2">Афиша</h1>
    <p class="text-gray-400 mb-8">Фильмы в прокате</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($movies as $movie)
        <a href="{{ route('movie.show', $movie->id) }}" class="card overflow-hidden hover:scale-105 transition-all duration-200">
            {{-- Постер --}}
            <div class="h-56 bg-gray-800 flex items-center justify-center overflow-hidden">
                @if($movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover" alt="{{ $movie->title }}">
                @else
                    <span class="text-5xl">🎬</span>
                @endif
            </div>
            
            {{-- Информация о фильме --}}
            <div class="p-4">
                <h3 class="text-lg font-semibold">{{ $movie->title }}</h3>
                <div class="flex justify-between items-center mt-2">
                    <div class="text-sm text-gray-400">{{ $movie->duration }} мин</div>
                    <div class="text-xs text-gray-500">{{ $movie->age_rating }}</div>
                </div>
                <div class="mt-3 pt-2 border-t border-gray-700 text-right">
                    <span class="text-sm text-purple-400">Билеты →</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $movies->links() }}
    </div>
</div>
@endsection