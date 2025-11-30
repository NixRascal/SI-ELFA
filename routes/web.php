<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/kuesioner/{kuesioner}', [QuestionnaireController::class, 'show'])->name('kuesioner.show');
    Route::get('/kuesioner/{kuesioner}/edit', [QuestionnaireController::class, 'edit'])->name('kuesioner.edit');
    Route::put('/kuesioner/{kuesioner}', [QuestionnaireController::class, 'update'])->name('kuesioner.update');
    Route::delete('/kuesioner/{kuesioner}', [QuestionnaireController::class, 'destroy'])->name('kuesioner.destroy');
    Route::post('/kuesioner/{kuesioner}/duplicate', [QuestionnaireController::class, 'duplicate'])->name('kuesioner.duplicate');
    Route::post('/kuesioner/{kuesioner}/toggle-status', [QuestionnaireController::class, 'toggleStatus'])->name('kuesioner.toggle-status');
    Route::get('/kuesioner/{kuesioner}/export', [QuestionnaireController::class, 'export'])->name('kuesioner.export');

    // Laporan
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [ReportController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/{id}/hasil', [ReportController::class, 'hasil'])->name('laporan.hasil');
    Route::get('/laporan/{id}/export', [ReportController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/{id}/print', [ReportController::class, 'print'])->name('laporan.print');
    Route::post('/laporan/{id}/ai-analysis', [ReportController::class, 'aiAnalysis'])->name('laporan.ai-analysis');

    // Profile
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Management
    Route::resource('admin', AdminManagementController::class)->except(['show']);
});