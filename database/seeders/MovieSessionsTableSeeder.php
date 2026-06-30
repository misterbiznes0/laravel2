<?php

namespace Database\Seeders;

use App\Models\MovieSession;
use App\Models\Movie;
use App\Models\Hall;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MovieSessionsTableSeeder extends Seeder
{
    public function run()
    {
        $movies = Movie::all();
        $halls = Hall::all();
        
        $today = Carbon::today();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            
            foreach ($movies as $movie) {
                // Случайное время начала: 10:00, 13:00, 16:00, 19:00, 22:00
                $startHours = [10, 13, 16, 19, 22];
                $startHour = $startHours[array_rand($startHours)];
                $startTime = $date->copy()->setTime($startHour, 0);
                
                $endTime = $startTime->copy()->addMinutes($movie->duration + 15);
                
                // Случайный зал
                $hall = $halls->random();
                
                // Случайная цена (от 250 до 800)
                $price = rand(250, 800);
                
                // Не все фильмы идут каждый день
                if (rand(1, 100) > 30) {
                    MovieSession::create([
                        'movie_id' => $movie->id,
                        'hall_id' => $hall->id,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'price' => $price,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}