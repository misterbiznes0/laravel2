<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Hall;
use App\Models\MovieSession;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ========== Dashboard ==========
    public function index()
    {
        $moviesCount = Movie::count();
        $hallsCount = Hall::count();
        $sessionsCount = MovieSession::count();
        $bookingsCount = Booking::count();
        
        return view('admin.dashboard', compact('moviesCount', 'hallsCount', 'sessionsCount', 'bookingsCount'));
    }

    // ========== Movies ==========
    public function movies()
    {
        $movies = Movie::latest()->paginate(10);
        return view('admin.movies', compact('movies'));
    }

    public function moviesCreate()
    {
        return view('admin.movies_form');
    }

    public function moviesStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'age_rating' => 'nullable|string',
            'release_date' => 'nullable|date',
        ]);

        if (empty($data['release_date'])) {
            $data['release_date'] = null;
        }

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Movie::create($data);
        return redirect()->route('admin.movies')->with('success', 'Фильм добавлен');
    }

    public function moviesEdit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies_form', compact('movie'));
    }

    public function moviesUpdate(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'age_rating' => 'nullable|string',
            'release_date' => 'nullable|date',
        ]);

        if (empty($data['release_date'])) {
            $data['release_date'] = null;
        }

        if ($request->has('delete_poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $data['poster'] = null;
        }

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($data);
        return redirect()->route('admin.movies')->with('success', 'Фильм обновлён');
    }

    public function moviesDelete($id)
    {
        $movie = Movie::findOrFail($id);
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }
        $movie->delete();
        return redirect()->route('admin.movies')->with('success', 'Фильм удалён');
    }

    // ========== Halls ==========
    public function halls()
    {
        $halls = Hall::latest()->paginate(10);
        return view('admin.halls', compact('halls'));
    }

    public function hallsCreate()
    {
        return view('admin.halls_form');
    }

    public function hallsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);

        Hall::create($request->all());
        return redirect()->route('admin.halls')->with('success', 'Зал добавлен');
    }

    public function hallsEdit($id)
    {
        $hall = Hall::findOrFail($id);
        return view('admin.halls_form', compact('hall'));
    }

    public function hallsUpdate(Request $request, $id)
    {
        $hall = Hall::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);
        $hall->update($request->all());
        return redirect()->route('admin.halls')->with('success', 'Зал обновлён');
    }

    public function hallsDelete($id)
    {
        Hall::findOrFail($id)->delete();
        return redirect()->route('admin.halls')->with('success', 'Зал удалён');
    }

    // ========== Sessions (Movie Sessions) ==========
    public function sessions()
    {
        $sessions = MovieSession::with(['movie', 'hall'])->latest()->paginate(10);
        return view('admin.sessions', compact('sessions'));
    }

    public function sessionsCreate()
    {
        $movies = Movie::all();
        $halls = Hall::all();
        return view('admin.sessions_form', compact('movies', 'halls'));
    }

    public function sessionsStore(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'hall_id' => 'required|exists:halls,id',
            'start_time' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        $end_time = Carbon::parse($request->start_time)->addMinutes($movie->duration + 15);

        MovieSession::create([
            'movie_id' => $request->movie_id,
            'hall_id' => $request->hall_id,
            'start_time' => $request->start_time,
            'end_time' => $end_time,
            'price' => $request->price,
            'is_active' => true,
        ]);

        return redirect()->route('admin.sessions')->with('success', 'Сеанс добавлен');
    }

    public function sessionsEdit($id)
    {
        $session = MovieSession::findOrFail($id);
        $movies = Movie::all();
        $halls = Hall::all();
        return view('admin.sessions_form', compact('session', 'movies', 'halls'));
    }

    public function sessionsUpdate(Request $request, $id)
    {
        $session = MovieSession::findOrFail($id);
        
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'hall_id' => 'required|exists:halls,id',
            'start_time' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        $end_time = Carbon::parse($request->start_time)->addMinutes($movie->duration + 15);

        $session->update([
            'movie_id' => $request->movie_id,
            'hall_id' => $request->hall_id,
            'start_time' => $request->start_time,
            'end_time' => $end_time,
            'price' => $request->price,
            'is_active' => true,
        ]);

        return redirect()->route('admin.sessions')->with('success', 'Сеанс обновлён');
    }

    public function sessionsDelete($id)
    {
        MovieSession::findOrFail($id)->delete();
        return redirect()->route('admin.sessions')->with('success', 'Сеанс удалён');
    }

    // ========== Bookings ==========
    public function bookings()
    {
        $bookings = Booking::with(['user', 'session.movie'])->latest()->paginate(20);
        return view('admin.bookings', compact('bookings'));
    }
}