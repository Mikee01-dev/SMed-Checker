<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\AdminController;

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
    Route::get('/', [DiagnosisController::class, 'index'])->name('index');
    Route::post('/process', [DiagnosisController::class, 'process'])->name('process');
    Route::get('/result/{riwayatId}', [DiagnosisController::class, 'result'])->name('result');
    Route::get('/download-pdf/{id}', [DiagnosisController::class, 'downloadPdf'])->name('download-pdf');
    Route::get('/about', [DiagnosisController::class, 'about'])->name('about');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/history', [AdminController::class, 'history'])->name('history');
    Route::get('/history/{id}', [AdminController::class, 'historyDetail'])->name('history.detail');
    Route::delete('/history/{id}', [AdminController::class, 'historyDestroy'])->name('history.destroy');
});


