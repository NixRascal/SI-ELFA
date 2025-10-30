<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [QuestionnaireController::class, 'index'])->name('beranda');

/*
|--------------------------------------------------------------------------
| Survey Routes
|--------------------------------------------------------------------------
*/

Route::prefix('survei')->name('survei.')->group(function () {
    Route::get('{questionnaire}', [SurveyController::class, 'showProfileForm'])
        ->name('profil');
    
    Route::post('{questionnaire}/profil', [SurveyController::class, 'storeProfile'])
        ->name('profil.simpan');
    
    Route::get('{questionnaire}/pertanyaan', [SurveyController::class, 'showQuestions'])
        ->name('pertanyaan');
    
    Route::post('{questionnaire}/jawaban', [SurveyController::class, 'storeAnswers'])
        ->name('jawaban.simpan');
    
    Route::get('{questionnaire}/selesai', [SurveyController::class, 'complete'])
        ->name('selesai');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    
    // Kuesioner Management
    Route::get('/kuesioner', [QuestionnaireController::class, 'manage'])->name('kuesioner.index');
    Route::get('/kuesioner/buat', [QuestionnaireController::class, 'create'])->name('kuesioner.create');
    Route::post('/kuesioner', [QuestionnaireController::class, 'store'])->name('kuesioner.store');
    
    // Laporan
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    
    // Admin Management
    Route::resource('admin', AdminManagementController::class)->except(['show']);
});