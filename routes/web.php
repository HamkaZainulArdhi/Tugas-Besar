<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RevisiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KategoriPenilaianController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\HasilPenilaianController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


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
// Route::get('admin/dashboard', [HomeController::class, 'index']);


//arahakan setelah berhasil upload jurnal
Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');

// Tampilkan jurnal berdasarkan filename
Route::get('/jurnalshow/{filename}', [JurnalController::class, 'showByFilename'])
    ->where('filename', '.*')
    ->name('jurnalshow');

// Simpan hasil review
Route::post('/jurnal/{jurnal}/review', [JurnalController::class, 'submitReview'])
    ->name('jurnal.review.submit');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/kategori', [KategoriPenilaianController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriPenilaianController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriPenilaianController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategoriPenilaian}/edit', [KategoriPenilaianController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategoriPenilaian}', [KategoriPenilaianController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategoriPenilaian}', [KategoriPenilaianController::class, 'destroy'])->name('kategori.destroy');
    Route::resource('hasil-penilaian', HasilPenilaianController::class)->except(['create', 'store']);
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// jurnal revisi
Route::middleware(['auth'])->group(function () {
    Route::get('/hasil-nilai', [RevisiController::class, 'index'])->name('hasil.nilai');
    Route::get('/hasil-nilai/{jurnal}', [RevisiController::class, 'hasilNilai'])->name('hasil.detail');
    Route::get('/revisi', [RevisiController::class, 'show'])->name('revisi.index');
    Route::get('/revisi/{jurnal}/create', [RevisiController::class, 'create'])->name('revisi.create');
    Route::post('/revisi/{jurnal}', [RevisiController::class, 'store'])->name('revisi.store');
    Route::get('/jurnal/{id}', [RevisiController::class, 'show'])->name('jurnal.show');
    Route::post('/jurnal/{id}/revision', [RevisiController::class, 'uploadRevision'])
        ->name('journal.revision.upload');
});


