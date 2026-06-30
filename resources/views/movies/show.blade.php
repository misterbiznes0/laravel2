{{-- resources/views/movies/show.blade.php --}}
@extends('layouts.app')
@section('title', $movie->title)

@section('content')
<div class="container max-w-5xl">
    <div class="card p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-1/3">
                @if($movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full rounded-xl shadow" alt="{{ $movie->title }}">
                @else
                    <div class="aspect-[2/3] bg-gray-800 rounded-xl flex items-center justify-center text-gray-500">без постера</div>
                @endif
            </div>
            <div class="md:w-2/3">
                <h1 class="text-3xl font-semibold">{{ $movie->title }}</h1>
                <div class="flex gap-3 text-gray-400 text-sm mt-2">
                    <span>{{ $movie->duration }} мин</span>
                    <span>{{ $movie->age_rating }}</span>
                    <span>{{ $movie->release_date?->format('d.m.Y') ?? 'дата не указана' }}</span>
                </div>
                <p class="text-gray-300 mt-4">{{ $movie->description }}</p>
                @if($movie->trailer_url)<div class="mt-4"><a href="{{ $movie->trailer_url }}" target="_blank" class="btn-outline">Трейлер</a></div>@endif
            </div>
        </div>
    </div>

    <h2 class="text-2xl font-semibold mb-4">Расписание сеансов</h2>
    @foreach($sessions as $date => $daySessions)
        <div class="mb-8">
            <div class="text-lg font-medium text-gray-300 mb-3 border-l-4 border-gray-600 pl-3">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y, l') }}</div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($daySessions as $session)
                    <a href="{{ route('booking.seats', $session->id) }}" class="card p-3 text-center hover:border-gray-500">
                        <div class="text-xl font-semibold">{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</div>
                        <div class="text-sm text-gray-400">{{ $session->hall->name }}</div>
                        <div class="text-sm text-gray-300">{{ number_format($session->price, 0, ',', ' ') }} ₽</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection