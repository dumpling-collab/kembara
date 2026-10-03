<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LoveBoardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\LocalPartnerController;

Route::get('/', HomeController::class)->name('home');
Route::get('/explore', [PlaceController::class, 'index'])->name('places.index');
Route::get('/explore/{tab}', [PlaceController::class, 'index'])->name('places.tab');
Route::get('/places/{place}', [PlaceController::class, 'show'])->name('places.show');

Route::get('/local-partners', [LocalPartnerController::class, 'index'])->name('local-partners.index');
Route::get('/local-partners/form', [LocalPartnerController::class, 'form'])->name('local-partners.form');
Route::post('/local-partners/form', [LocalPartnerController::class, 'store'])->name('local-partners.store');

// Setelah login Breeze mengarah ke "dashboard" -> kita arahkan ke beranda
Route::get('/dashboard', fn () => redirect()->route('home'))
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    Route::get('/trips/{trip}/places', [TripController::class, 'places'])->name('trips.places');
    Route::post('/trips/{trip}/places/{place}', [TripController::class, 'togglePlace'])->name('trips.places.toggle');
    Route::get('/trips/{trip}/route', [TripController::class, 'startingPoint'])->name('trips.route');
    Route::post('/trips/{trip}/route', [TripController::class, 'saveStartingPoint'])->name('trips.route.store');
    Route::get('/trips/{trip}/transport', [TripController::class, 'transport'])->name('trips.transport');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/love-board', [LoveBoardController::class, 'index'])->name('love-board.index');
    Route::post('/trips/{trip}/love-board', [LoveBoardController::class, 'save'])->name('love-board.save');
    Route::post('/trips/{trip}/love-board/favorite', [LoveBoardController::class, 'toggleFavoriteRoute'])->name('love-board.favorite');
    Route::post('/places/{place}/favorite', [LoveBoardController::class, 'togglePlaceFavorite'])->name('places.favorite');

    Route::get('/challenge', [ChallengeController::class, 'index'])->name('challenge.index');
    Route::get('/challenge/passport', [ChallengeController::class, 'passport'])->name('challenge.passport');
    Route::get('/challenge/{challenge}', [ChallengeController::class, 'show'])->name('challenge.show');
    Route::post('/challenge/{challenge}/claim', [ChallengeController::class, 'claim'])->name('challenge.claim');
    Route::get('/challenge/{challenge}/claimed', [ChallengeController::class, 'claimed'])->name('challenge.claimed');
    Route::post('/checkpoint/{checkpoint}/verify', [ChallengeController::class, 'verifyCheckpoint'])->name('challenge.checkpoint.verify');

    Route::get('/credits/top-up', [CreditController::class, 'index'])->name('credit.top-up');
    Route::post('/credits/top-up/{amount}', [CreditController::class, 'purchase'])->name('credit.purchase');
});

require __DIR__.'/auth.php';