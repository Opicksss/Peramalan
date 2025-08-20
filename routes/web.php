<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlphaController;
use App\Http\Controllers\AcountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PeramalanController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login-proses', [AuthController::class, 'login_proses'])->name('login-proses');
    Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('/forgot-proses', [AuthController::class, 'forgot_proses'])->name('forgot-proses');
    Route::get('verify-code', [AuthController::class, 'verify_code'])->name('verify-code');
    Route::post('verify-code-proses', [AuthController::class, 'verify_code_proses'])->name('verify-code-proses');
    Route::get('reset-password', [AuthController::class, 'reset_password'])->name('reset-password');
    Route::post('reset-password-proses', [AuthController::class, 'reset_password_proses'])->name('reset-password-proses');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('userAkses:admin')->group(function () {
        Route::get('acount', [AcountController::class, 'index'])->name('acount.index');
        Route::post('acount/store', [AcountController::class, 'store'])->name('acount.store');
        Route::put('acount/{user}', [AcountController::class, 'update'])->name('acount.update');
        Route::delete('acount/{user}', [AcountController::class, 'destroy'])->name('acount.destroy');
        
        Route::put('penjualan/{penjualan}', [PenjualanController::class, 'update'])->name('penjualan.update');
        Route::delete('penjualan/{penjualan}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    });

    Route::get('penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::post('penjualan/import', [PenjualanController::class, 'importPenjualan'])->name('penjualan.import');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile-foto/{user}', [ProfileController::class, 'foto'])->name('profile.foto');
    Route::put('profile-reset/{user}', [ProfileController::class, 'reset'])->name('profile.reset');

    Route::get('peramalan', [PeramalanController::class, 'index'])->name('peramalan.index');

    Route::post('update-alpha', [AlphaController::class, 'updateAlpha'])->name('alpha.update');
});

Route::get('/home', function () {
    return redirect('/dashboard');
});
