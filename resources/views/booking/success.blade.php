<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Бронь создана</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-900 text-white p-6">
    <div class="container mx-auto text-center">
        <div class="bg-green-700 p-4 rounded mb-6">✅ Билет успешно забронирован!</div>
        <h1 class="text-2xl font-bold">{{ $booking->session->movie->title }}</h1>
        <p>{{ $booking->session->hall->name }} • {{ \Carbon\Carbon::parse($booking->session->start_time)->format('d.m.Y H:i') }}</p>
        <p>Места: {{ implode(', ', json_decode($booking->selected_seats, true)) }}</p>
        <p>Сумма: {{ $booking->total_price }} ₽</p>
        <a href="/" class="text-purple-400 underline mt-4 block">На главную</a>
    </div>
</body>
</html>