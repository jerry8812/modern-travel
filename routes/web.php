<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $loginUser = auth()->user();

    if ($loginUser) {
        return redirect('dashboard');
    }

    return redirect('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/rental-car', fn () => Inertia::render('RentalCars'))->name('rental-car');
    Route::get('/tour-guide', fn () => Inertia::render('TourGuides'))->name('tour-guide');
    Route::get('trips/create-trip', [TripController::class, 'createTrip'])->name('create-trip');
    Route::resource('trips', TripController::class)->only(['update', 'store', 'update', 'edit']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
