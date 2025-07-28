<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kepsek\DashboardController;
use App\Http\Controllers\Kepsek\ProfileController;
use App\Http\Controllers\Kepsek\SiswaController;
use App\Http\Controllers\Kepsek\AbsensiController;
use App\Http\Controllers\Kepsek\SPPController;
use App\Http\Controllers\Kepsek\KeuanganController;

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
        Route::get('/charts/siswa', [DashboardController::class, 'getSiswaChartData'])
         ->name('kepsek.charts.siswa');
        Route::get('/charts/keuangan', [DashboardController::class, 'getKeuanganChartData'])
         ->name('kepsek.charts.keuangan');
        Route::get('/data-siswa', [SiswaController::class, 'index'])
         ->name('kepsek.siswa.index');
        Route::get('/absensi', [AbsensiController::class, 'index'])
         ->name('kepsek.absensi.index');
        Route::get('/absensi/isi/{tanggal}', [AbsensiController::class, 'create'])
         ->name('kepsek.absensi.create');
        Route::get('/spp', [SPPController::class, 'index'])
         ->name('kepsek.spp.index');
        Route::get('/spp/{tahun}/{bulan}', [SPPController::class, 'show'])
         ->name('kepsek.spp.show');
        Route::get('/keuangan', [KeuanganController::class, 'index'])
         ->name('kepsek.keuangan.index');
        Route::post('/keuangan/export', [KeuanganController::class, 'export'])
         ->name('kepsek.keuangan.export');
        Route::get('/profile', [ProfileController::class, 'index'])
         ->name('kepsek.profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])
         ->name('kepsek.profile.update');
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