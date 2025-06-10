<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurnalController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// route juranl dan read jurnal di tabel admin
Route::get('/jurnal', [JurnalController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('jurnal');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// arahakan admin ke dasboard admin
Route::get('admin/dashboard', [HomeController::class, 'index']);

//arahakan setelah berhasil upload jurnal
Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');

// review jurnal
Route::get('/jurnalshow/{filename}', [JurnalController::class, 'showByFilename'])
    ->where('filename', '.*')
    ->name('jurnalshow');
