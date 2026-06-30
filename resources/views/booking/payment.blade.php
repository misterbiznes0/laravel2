<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата | Кинотеатр</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-8 text-center">
        <div class="bg-gray-800 p-8 rounded-xl max-w-md mx-auto">
            <h1 class="text-2xl font-bold mb-4">Оплата билета</h1>
            <p class="mb-2">Фильм: <strong>{{ $booking->session->movie->title }}</strong></p>
            <p class="mb-2">Места: <strong>{{ implode(', ', json_decode($booking->selected_seats, true)) }}</strong></p>
            <p class="mb-4">Сумма: <strong class="text-purple-400 text-xl">{{ number_format($booking->total_price, 0, ',', ' ') }} ₽</strong></p>
            
            <form method="POST" action="{{ route('booking.process', $booking->id) }}">
                @csrf
                <button type="submit" class="bg-purple-600 px-8 py-3 rounded-xl text-lg font-bold hover:bg-purple-700 w-full">
                    Оплатить
                </button>
            </form>
        </div>
    </div>
</body>
</html>