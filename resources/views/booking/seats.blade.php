{{-- resources/views/booking/seats.blade.php --}}
@extends('layouts.app')
@section('title', $session->movie->title)
@section('content')
<div class="container max-w-6xl mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-semibold">{{ $session->movie->title }}</h1>
        <div class="text-gray-400 text-base">{{ $session->hall->name }} · {{ \Carbon\Carbon::parse($session->start_time)->format('d.m.Y H:i') }}</div>
        <div class="text-gray-400 text-sm">Обычный билет {{ number_format($session->price, 0, ',', ' ') }} ₽ / VIP ×1.5</div>
    </div>

    <div class="card p-6">
        <div class="text-center text-sm text-gray-500 mb-6 border-b border-gray-700 pb-2">ЭКРАН</div>

        <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
            @csrf
            <input type="hidden" name="movie_session_id" value="{{ $session->id }}">
            <div id="selectedSeatsContainer"></div>

            @php
                $rows = $session->hall->rows;
                $cols = $session->hall->seats_per_row;
                $vipRows = array_merge(range(1, 2), range($rows - 1, $rows));
            @endphp

            <div class="overflow-x-auto">
                <div class="inline-block min-w-full" style="margin: 0 auto; display: table;">
                    @for ($row = 1; $row <= $rows; $row++)
                        <div class="flex justify-center items-center gap-2 md:gap-3 mb-2">
                            <div class="w-8 text-center text-sm font-medium text-gray-400">{{ $row }}</div>

                            @for ($seat = 1; $seat <= $cols; $seat++)
                                @php
                                    $seatId = "{$row}-{$seat}";
                                    $isBooked = in_array($seatId, $bookedSeats);
                                    $isVip = in_array($row, $vipRows);
                                    $seatClass = 'seat-free';
                                    if ($isBooked) $seatClass = 'seat-booked';
                                    elseif ($isVip) $seatClass = 'seat-vip';
                                @endphp
                                <button type="button"
                                        data-seat="{{ $seatId }}"
                                        data-vip="{{ $isVip ? 'true' : 'false' }}"
                                        class="seat {{ $seatClass }} w-10 h-10 md:w-12 md:h-12 rounded-lg text-sm md:text-base font-semibold transition-all duration-150"
                                        {{ $isBooked ? 'disabled' : '' }}>
                                    {{ $seat }}
                                </button>
                            @endfor

                            <div class="w-8 text-center text-sm font-medium text-gray-400">{{ $row }}</div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-5 mt-8 text-sm text-gray-400">
                <div><span class="inline-block w-5 h-5 bg-gray-700 rounded-md align-middle mr-2"></span> Свободно</div>
                <div><span class="inline-block w-5 h-5 bg-amber-600 rounded-md align-middle mr-2"></span> VIP</div>
                <div><span class="inline-block w-5 h-5 bg-green-600 rounded-md align-middle mr-2"></span> Выбрано</div>
                <div><span class="inline-block w-5 h-5 bg-red-800 rounded-md align-middle mr-2"></span> Занято</div>
            </div>

            <div class="text-center mt-8 p-4 bg-gray-900 rounded-xl max-w-sm mx-auto">
                <div class="text-base">Выбрано мест: <span id="selectedCount" class="font-bold text-2xl text-white">0</span></div>
                <div class="text-xl mt-1"><span id="totalPrice" class="font-bold text-2xl text-white">0</span> ₽</div>
                <button type="submit" id="submitBtn" disabled class="mt-4 btn-solid text-base py-2 px-6 w-full disabled:opacity-40">Забронировать</button>
            </div>
        </form>
    </div>
</div>

<script>
    const price = {{ $session->price }};
    const vipRows = @json($vipRows);
    const mult = 1.5;
    let selected = [];

    function seatPrice(seatId) {
        let row = parseInt(seatId.split('-')[0]);
        return vipRows.includes(row) ? price * mult : price;
    }

    function updateUI() {
        let container = document.getElementById('selectedSeatsContainer');
        container.innerHTML = '';
        selected.forEach(s => {
            let inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = 'seats[]';
            inp.value = s;
            container.appendChild(inp);
        });
        document.getElementById('selectedCount').innerText = selected.length;
        let total = 0;
        selected.forEach(s => total += seatPrice(s));
        document.getElementById('totalPrice').innerText = total;
        document.getElementById('submitBtn').disabled = selected.length === 0;
    }

    document.querySelectorAll('.seat:not([disabled])').forEach(btn => {
        btn.addEventListener('click', () => {
            const seat = btn.dataset.seat;
            const vip = btn.dataset.vip === 'true';
            const idx = selected.indexOf(seat);
            if (idx === -1) {
                selected.push(seat);
                btn.classList.remove('seat-free', 'seat-vip');
                btn.classList.add('seat-selected');
            } else {
                selected.splice(idx, 1);
                btn.classList.remove('seat-selected');
                if (vip) btn.classList.add('seat-vip');
                else btn.classList.add('seat-free');
            }
            updateUI();
        });
    });
    updateUI();
</script>

<style>
    .seat {
        transition: all 0.15s ease;
        cursor: pointer;
        background-color: #2d3748;
        border: 1px solid #4a5568;
        color: #e2e8f0;
    }
    .seat-free {
        background-color: #2d3748;
        border: 1px solid #4a5568;
        color: #e2e8f0;
    }
    .seat-vip {
        background-color: #d97706;
        border: 1px solid #f59e0b;
        color: white;
        font-weight: bold;
    }
    .seat-selected {
        background-color: #10b981 !important;
        border: 1px solid #34d399;
        color: white;
        box-shadow: 0 0 0 1px #10b981;
    }
    .seat-booked {
        background-color: #991b1b !important;
        border: 1px solid #ef4444;
        color: #9ca3af;
        text-decoration: line-through;
        cursor: not-allowed;
        opacity: 0.7;
    }
    .seat:hover:not(.seat-booked) {
        transform: scale(1.02);
        filter: brightness(1.05);
    }
</style>
@endsection