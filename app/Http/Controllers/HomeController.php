<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieSession;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $now_playing = Movie::where('release_date', '<=', Carbon::today())
            ->orderBy('release_date', 'desc')
            ->take(6)
            ->get();
            
        $coming_soon = Movie::where('release_date', '>', Carbon::today())
            ->orderBy('release_date', 'asc')
            ->take(6)
            ->get();
            
        return view('home', compact('now_playing', 'coming_soon'));
    }
    
    public function movies()
    {
        $movies = Movie::orderBy('release_date', 'desc')->paginate(12);
        return view('movies.index', compact('movies'));
    }
    
    public function movie($id)
    {
        $movie = Movie::findOrFail($id);
        $sessions = MovieSession::where('movie_id', $id)
            ->where('start_time', '>=', Carbon::today())
            ->with('hall')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($session) {
                return Carbon::parse($session->start_time)->format('Y-m-d');
            });
            
        return view('movies.show', compact('movie', 'sessions'));
    }
    
    public function schedule()
    {
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Carbon::today()->addDays($i);
        }
        
        $selectedDate = request('date') ? Carbon::parse(request('date')) : Carbon::today();
        $sessions = MovieSession::whereDate('start_time', $selectedDate)
            ->with(['movie', 'hall'])
            ->orderBy('start_time')
            ->get();
            
        return view('schedule', compact('dates', 'selectedDate', 'sessions'));
    }
}