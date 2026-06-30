{{-- resources/views/admin/bookings.blade.php --}}
@extends('admin.dashboard')
@section('admin-content')
<h1 class="text-2xl font-bold mb-4">Бронирования</h1>
<div class="card">
    <table class="table">
        <thead>
            <tr><th>Пользователь</th><th>Фильм</th><th>Дата сеанса</th><th>Места</th><th>Сумма</th><th>Статус</th></tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->session->movie->title }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->session->start_time)->format('d.m.Y H:i') }}</td>
                <td>{{ implode(', ', $booking->selected_seats ?? []) }}</td>
                <td>{{ number_format($booking->total_price, 0, ',', ' ') }} ₽</td>
                <td>{{ $booking->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bookings->links() }}
</div>
@endsection