<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kepsek\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda mendaftarkan semua rute web untuk aplikasi Anda.
|
*/

// ===================================================================
// Rute-rute ini dapat diakses oleh siapa saja (tidak perlu login)
// ===================================================================

// Mengarahkan rute utama (/) ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Menampilkan form login
Route::get('/login', [AuthController::class, 'login'])->name('login');

// Memproses data dari form login
Route::post('/login', [AuthController::class, 'store']);


// =====================================================================
// Rute-rute ini HANYA dapat diakses oleh pengguna yang sudah login
// =====================================================================
Route::middleware('auth')->group(function () {
    
    // Rute untuk proses logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rute Grup untuk Kepala Sekolah
    Route::middleware('role:kepala sekolah')->prefix('kepsek')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
             ->name('kepala-sekolah.dashboard');
    });

    // Rute Grup untuk Guru
    Route::middleware('role:guru')->prefix('guru')->group(function () {
        Route::get('/dashboard', function() {
            return 'Ini Dashboard Guru';
        })->name('guru.dashboard');
    });

    // Rute Grup untuk Bendahara
    Route::middleware('role:bendahara')->prefix('bendahara')->group(function () {
        Route::get('/dashboard', function() {
            return 'Ini Dashboard Bendahara';
        })->name('bendahara.dashboard');
    });

    // Rute Grup untuk Operator
    Route::middleware('role:operator')->prefix('operator')->group(function () {
        Route::get('/dashboard', function() {
            return 'Ini Dashboard Operator';
        })->name('operator.dashboard');
    });

});