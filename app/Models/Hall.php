<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = ['name', 'rows', 'seats_per_row'];
    
    public function sessions()
    {
        return $this->hasMany(MovieSession::class, 'hall_id');
    }
}