{{-- resources/views/booking/history.blade.php --}}
@extends('layouts.app')
@section('title', 'Мои билеты')
@section('content')
<div class="container">
    <h1 class="text-3xl font-semibold mb-6">Мои билеты</h1>
    @if($bookings->count())
        @foreach($bookings as $booking)
        <div class="card p-4 mb-4">
            <div class="flex flex-wrap justify-between items-start gap-3">
                <div>
                    <div class="text-xl font-medium">{{ $booking->session->movie->title }}</div>
                    <div class="text-sm text-gray-400">{{ $booking->session->hall->name }} · {{ \Carbon\Carbon::parse($booking->session->start_time)->format('d.m.Y H:i') }}</div>
                    <div class="text-sm text-gray-400">Места: {{ is_array($booking->selected_seats) ? implode(', ', $booking->selected_seats) : $booking->selected_seats }}</div>
                </div>
                <div class="text-right">
                    <div class="text-lg font-semibold text-white">{{ number_format($booking->total_price, 0, ',', ' ') }} ₽</div>
                    <div class="mt-2 space-x-3">
                        <a href="{{ route('booking.ticket', $booking->id) }}" class="text-sm border border-emerald-600 text-emerald-400 rounded-full px-3 py-1 inline-block hover:bg-emerald-900 hover:text-white">PDF билет</a>
                        <a href="{{ route('booking.cancel', $booking->id) }}" class="text-sm border border-red-700 text-red-400 rounded-full px-3 py-1 inline-block hover:bg-red-900" onclick="return confirm('Отменить бронь? Места станут доступны.')">Отменить</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div>{{ $bookings->links() }}</div>
    @else
        <div class="card p-12 text-center"><p class="text-gray-400">У вас пока нет билетов</p><a href="/movies" class="btn-outline inline-block mt-4">Выбрать фильм</a></div>
    @endif
</div>
@endsection