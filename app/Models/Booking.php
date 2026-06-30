<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    
    protected $fillable = [
        'user_id',
        'movie_session_id',
        'selected_seats',
        'total_price',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // Автоматическое преобразование JSON → массив при получении
    public function getSelectedSeatsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        
        $decoded = json_decode($value, true);
        
        // Если после декодирования всё ещё строка — декодируем ещё раз
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }
        
        return is_array($decoded) ? $decoded : [];
    }

    // Автоматическое преобразование массива → JSON при сохранении
    public function setSelectedSeatsAttribute($value)
    {
        $this->attributes['selected_seats'] = json_encode($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(MovieSession::class, 'movie_session_id');
    }
}