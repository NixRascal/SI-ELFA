<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\KuesionerController;

Route::get('/', [App\Http\Controllers\KuesionerController::class, 'index']);

Route::get('/survei/{kuesioner}', [SurveiController::class, 'tampilFormProfilResponden'])
    ->name('survei.profil.tampil');

Route::post('/survei/{kuesioner}/profil', [SurveiController::class, 'simpanProfilResponden'])
    ->name('survei.profil.simpan');

Route::get('/survei/{kuesioner}/pertanyaan', [SurveiController::class, 'tampilFormJawabanSurvei'])
    ->name('survei.jawaban.tampil');

Route::post('/survei/{kuesioner}/jawaban', [SurveiController::class, 'simpanJawabanSurvei'])
    ->name('survei.submit');

    
Route::get('/survei/{kuesioner}/selesai', [SurveiController::class, 'halamanSelesai'])
    ->name('survei.selesai');