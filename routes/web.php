<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Главная и фильмы
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [HomeController::class, 'movies'])->name('movies.index');
Route::get('/movie/{id}', [HomeController::class, 'movie'])->name('movie.show');
Route::get('/schedule', [HomeController::class, 'schedule'])->name('schedule');

// Бронирование
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/seats/{movie_session_id}', [BookingController::class, 'selectSeats'])->name('booking.seats');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation/{id}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/booking/ticket/{id}', [BookingController::class, 'ticket'])->name('booking.ticket');
    Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/booking/cancel/{id}', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// Админка
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/movies', [AdminController::class, 'movies'])->name('admin.movies');
    Route::get('/movies/create', [AdminController::class, 'moviesCreate'])->name('admin.movies.create');
    Route::post('/movies/store', [AdminController::class, 'moviesStore'])->name('admin.movies.store');
    Route::get('/movies/edit/{id}', [AdminController::class, 'moviesEdit'])->name('admin.movies.edit');
    Route::post('/movies/update/{id}', [AdminController::class, 'moviesUpdate'])->name('admin.movies.update');
    Route::get('/movies/delete/{id}', [AdminController::class, 'moviesDelete'])->name('admin.movies.delete');
    
    Route::get('/halls', [AdminController::class, 'halls'])->name('admin.halls');
    Route::get('/halls/create', [AdminController::class, 'hallsCreate'])->name('admin.halls.create');
    Route::post('/halls/store', [AdminController::class, 'hallsStore'])->name('admin.halls.store');
    Route::get('/halls/edit/{id}', [AdminController::class, 'hallsEdit'])->name('admin.halls.edit');
    Route::post('/halls/update/{id}', [AdminController::class, 'hallsUpdate'])->name('admin.halls.update');
    Route::get('/halls/delete/{id}', [AdminController::class, 'hallsDelete'])->name('admin.halls.delete');
    
    Route::get('/sessions', [AdminController::class, 'sessions'])->name('admin.sessions');
    Route::get('/sessions/create', [AdminController::class, 'sessionsCreate'])->name('admin.sessions.create');
    Route::post('/sessions/store', [AdminController::class, 'sessionsStore'])->name('admin.sessions.store');
    Route::get('/sessions/edit/{id}', [AdminController::class, 'sessionsEdit'])->name('admin.sessions.edit');
    Route::post('/sessions/update/{id}', [AdminController::class, 'sessionsUpdate'])->name('admin.sessions.update');
    Route::get('/sessions/delete/{id}', [AdminController::class, 'sessionsDelete'])->name('admin.sessions.delete');
    
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
});

require __DIR__.'/auth.php';

Gate::define('admin', function ($user) {
    return $user->is_admin == 1;
});