<?php
// routes/api.php

use App\Http\Controllers\API\APIjurnal;
use App\Http\Controllers\API\HasilPenilaianController;
use App\Http\Controllers\API\KategoriNilai;
use App\Http\Controllers\API\JournalRevisionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiRegisteredUserController;


Route::post('/register', [ApiRegisteredUserController::class, 'store']);
Route::get('/users', [ApiRegisteredUserController::class, 'index']);
Route::delete('/users/{id}', [ApiRegisteredUserController::class, 'destroy']);
Route::put('/users/{id}', [ApiRegisteredUserController::class, 'update']);


Route::get('/jurnals', [APIjurnal::class, 'index']);
Route::middleware('auth:sanctum')->post('/jurnals', [APIJurnal::class, 'store']);


Route::get('/kategori-penilaian', [KategoriNilai::class, 'index']);
Route::post('/kategori-penilaian', [KategoriNilai::class, 'store']);
Route::put('/kategori-penilaian/{id}', [KategoriNilai::class, 'update']);
Route::delete('/kategori-penilaian/{id}', [KategoriNilai::class, 'destroy']);


Route::get('/hasil-penilaian', [HasilPenilaianController::class, 'index']);
Route::post('/hasil-penilaian', [HasilPenilaianController::class, 'store']);


Route::get('/journal-revisions', [JournalRevisionController::class, 'index']);
Route::post('/journal-revisions', [JournalRevisionController::class, 'store']);