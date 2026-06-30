<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'description', 'poster', 'duration', 'release_date', 'age_rating'];
    
    protected $casts = [
        'release_date' => 'date',
    ];
    
    public function sessions()
    {
        return $this->hasMany(MovieSession::class, 'movie_id');
    }
}