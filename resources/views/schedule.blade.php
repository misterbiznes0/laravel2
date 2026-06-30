{{-- resources/views/schedule.blade.php --}}
@extends('layouts.app')
@section('title', 'Расписание')
@section('content')
<div class="container">
    <h1 class="text-3xl font-semibold mb-2">Расписание</h1>
    <div class="flex flex-wrap gap-3 my-6">
        @foreach($dates as $date)
        <a href="?date={{ $date->format('Y-m-d') }}" class="px-4 py-2 rounded-full text-sm {{ $selectedDate->format('Y-m-d') == $date->format('Y-m-d') ? 'bg-gray-700 text-white' : 'bg-gray-900 text-gray-300 border border-gray-700' }}">{{ $date->translatedFormat('d M') }}</a>
        @endforeach
    </div>
    @forelse($sessions as $session)
    <div class="card p-5 mb-4 flex flex-wrap justify-between items-center">
        <div>
            <div class="text-xl font-semibold">{{ $session->movie->title }}</div>
            <div class="text-sm text-gray-400">{{ $session->hall->name }} · {{ $session->movie->duration }} мин · {{ $session->movie->age_rating }}</div>
        </div>
        <div class="text-right">
            <div class="text-2xl font-medium">{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</div>
            <div class="text-sm text-gray-400">{{ number_format($session->price, 0, ',', ' ') }} ₽</div>
            <a href="{{ route('booking.seats', $session->id) }}" class="btn-outline text-sm mt-2 inline-block">Выбрать места</a>
        </div>
    </div>
    @empty<div class="card p-8 text-center"><p class="text-gray-400">Нет сеансов в этот день</p></div>@endforelse
</div>
@endsection