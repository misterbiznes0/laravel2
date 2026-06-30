{{-- resources/views/booking/confirmation.blade.php --}}
@extends('layouts.app')
@section('title', 'Бронь создана')
@section('content')
<div class="container">
    <div class="card p-6 text-center max-w-md mx-auto">
        <div class="text-green-400 text-4xl mb-3">✓</div>
        <h2 class="text-xl font-semibold mb-2">Билет забронирован</h2>
        <p class="text-gray-400 mb-1">{{ $booking->session->movie->title }}</p>
        <p class="text-sm text-gray-500">{{ $booking->session->hall->name }} · {{ \Carbon\Carbon::parse($booking->session->start_time)->format('d.m.Y H:i') }}</p>
        <p class="text-sm text-gray-500 mb-4">Места: {{ implode(', ', $booking->selected_seats ?? []) }}</p>
        <div class="flex gap-3 justify-center">
            <a href="/" class="btn-outline">На главную</a>
            <a href="{{ route('booking.ticket', $booking->id) }}" class="btn-solid">Скачать PDF</a>
        </div>
    </div>
</div>
@endsection