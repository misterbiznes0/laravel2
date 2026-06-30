<?php

namespace App\Http\Controllers;

use App\Models\MovieSession;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    const VIP_MULTIPLIER = 1.5;

    // Страница выбора мест
    public function selectSeats($id)
    {
        $session = MovieSession::with('movie', 'hall')->findOrFail($id);

        $bookedSeats = $session->bookings()
            ->where('status', 'paid')
            ->get()
            ->flatMap(fn($b) => $b->selected_seats)
            ->toArray();

        $rows = $session->hall->rows;
        $vipRows = array_merge(range(1, 2), range($rows - 1, $rows));

        return view('booking.seats', compact('session', 'bookedSeats', 'vipRows'));
    }

    // Сохранение брони
    public function store(Request $request)
    {
        \Log::info('Данные формы:', $request->all());

        $request->validate([
            'movie_session_id' => 'required|exists:movie_sessions,id',
            'seats' => 'required|array|min:1',
        ]);

        $session = MovieSession::findOrFail($request->movie_session_id);

        // Проверка занятости мест
        $bookedSeats = $session->bookings()
            ->where('status', 'paid')
            ->get()
            ->flatMap(fn($b) => $b->selected_seats)
            ->toArray();

        foreach ($request->seats as $seat) {
            if (in_array($seat, $bookedSeats)) {
                return back()->with('error', "Место {$seat} уже занято");
            }
        }

        // Расчёт суммы с учётом VIP
        $rows = $session->hall->rows;
        $vipRows = array_merge(range(1, 2), range($rows - 1, $rows));
        $totalPrice = 0;

        foreach ($request->seats as $seat) {
            $row = explode('-', $seat)[0];
            if (in_array($row, $vipRows)) {
                $totalPrice += $session->price * self::VIP_MULTIPLIER;
            } else {
                $totalPrice += $session->price;
            }
        }

        // Создаём бронь
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'movie_session_id' => $session->id,
            'selected_seats' => $request->seats,
            'total_price' => $totalPrice,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('booking.confirmation', $booking->id);
    }

    // Страница подтверждения
    public function confirmation($id)
    {
        $booking = Booking::with('session.movie', 'session.hall')->findOrFail($id);
        if ($booking->user_id !== Auth::id()) abort(403);
        return view('booking.confirmation', compact('booking'));
    }

    // История броней
    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('session.movie', 'session.hall')
            ->latest()
            ->paginate(10);
        return view('booking.history', compact('bookings'));
    }

    // Скачивание PDF
    public function ticket($id)
    {
        $booking = Booking::with('session.movie', 'session.hall')->findOrFail($id);
        if ($booking->user_id !== Auth::id()) abort(403);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('booking.ticket_pdf', compact('booking'));
        return $pdf->download("ticket_{$booking->id}.pdf");
    }

    // Отмена брони
public function cancel($id)
{
    $booking = Booking::findOrFail($id);
    
    if ($booking->user_id !== Auth::id()) {
        abort(403);
    }
    
    // Убираем проверку на оплаченный билет — отмена всем
    $booking->delete();
    
    return redirect()->route('bookings.history')->with('success', 'Бронирование удалено, места снова доступны.');
}
}