<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Электронный билет</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; text-align: center; }
        .ticket { border: 2px solid #6d28d9; padding: 20px; width: 80%; margin: auto; border-radius: 15px; }
        h1 { color: #6d28d9; }
        .info { margin: 20px 0; line-height: 1.6; }
        .footer { margin-top: 30px; font-size: 12px; color: #555; }
        .movie-title { font-size: 22px; font-weight: bold; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="ticket">
        <h1>Кинотеатр</h1>
        <div class="movie-title">{{ $booking->session->movie->title }}</div>
        <div class="info">
            <p><strong>Зал:</strong> {{ $booking->session->hall->name }}</p>
            <p><strong>Дата и время:</strong> {{ \Carbon\Carbon::parse($booking->session->start_time)->format('d.m.Y H:i') }}</p>
            <p><strong>Места:</strong> {{ implode(', ', $booking->selected_seats ?? []) }}</p>
            <p><strong>Сумма:</strong> {{ number_format($booking->total_price, 0, ',', ' ') }} ₽</p>
        </div>
        <div class="footer">Счастливого просмотра! Сохраняйте билет до окончания сеанса.</div>
    </div>
</body>
</html>