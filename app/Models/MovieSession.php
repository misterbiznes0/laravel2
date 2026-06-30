<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieSession extends Model
{
    protected $table = 'movie_sessions';
    protected $fillable = ['movie_id', 'hall_id', 'start_time', 'end_time', 'price', 'is_active'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'movie_session_id');
    }

    public function getBookedSeatsAttribute()
    {
        return $this->bookings()
            ->where('status', 'paid')
            ->get()
            ->flatMap(fn($booking) => json_decode($booking->selected_seats, true))
            ->toArray();
    }
}