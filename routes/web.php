<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorController;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Pagina per utente non loggato(metti bottone per login)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function () {
    // Rotta per spostare un elemento nel cestino
    Route::get('/apartments/trash', [ApartmentController::class, 'trash'])->name('apartments.trash');
    // Rotta ripristino elemento dal cestino
    Route::patch('/apartments/{apartment}/restore', [ApartmentController::class, 'restore'])->name('apartments.restore')->withTrashed();
    // Rotta per l'eliminazione definitiva di un elemento
    Route::delete('/apartments/{apartment}/drop', [ApartmentController::class, 'drop'])->name('apartments.drop')->withTrashed();
    // Svuota tutto il cestino
    Route::delete('/apartments/empty', [ApartmentController::class, 'empty'])->name('apartments.empty');
    // Ripristina tutto il cestino
    Route::patch('/apartments/returned', [ApartmentController::class, 'returned'])->name('apartments.returned');
    // Resources list
    Route::resource('apartments', ApartmentController::class)->withTrashed(['show', 'edit', 'update']);
    // Rotta sponsorizzazioni
    Route::get('/sponsor', [SponsorController::class, 'index'])->name('sponsors.index');
});




// dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
