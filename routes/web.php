<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\Kepsek\ProfileController as KepsekProfileController;
use App\Http\Controllers\Kepsek\SiswaController as KepsekSiswaController;
use App\Http\Controllers\Kepsek\AbsensiController as KepsekAbsensiController;
use App\Http\Controllers\Kepsek\SPPController as KepsekSPPController;
use App\Http\Controllers\Kepsek\KeuanganController as KepsekKeuanganController;
use App\Http\Controllers\Kepsek\GuruController as KepsekGuruController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\ProfileController as OperatorProfileController;
use App\Http\Controllers\Operator\SiswaController as OperatorSiswaController;
use App\Http\Controllers\Operator\GuruController as OperatorGuruController;
use App\Http\Controllers\Bendahara\DashboardController as BendaharaDashboardController;
use App\Http\Controllers\Bendahara\ProfileController as BendaharaProfileController;
use App\Http\Controllers\Bendahara\SPPController as BendaharaSPPController;
use App\Http\Controllers\Bendahara\KeuanganController as BendaharaKeuanganController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\ProfileController as GuruProfileController;
use App\Http\Controllers\Guru\SiswaController as GuruSiswaController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;

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
    Route::middleware('role:kepala sekolah')->prefix('kepsek')->group(function () 
    {
        Route::get('/dashboard', [KepsekDashboardController::class, 'index'])
             ->name('kepala-sekolah.dashboard');
        Route::get('/charts/siswa', [KepsekDashboardController::class, 'getSiswaChartData'])
             ->name('kepsek.charts.siswa');
        Route::get('/charts/keuangan', [KepsekDashboardController::class, 'getKeuanganChartData'])
             ->name('kepsek.charts.keuangan');
        Route::get('/data-siswa', [KepsekSiswaController::class, 'index'])
             ->name('kepsek.siswa.index');
        Route::get('/absensi', [KepsekAbsensiController::class, 'index'])
             ->name('kepsek.absensi.index');
        Route::get('/absensi/isi/{tanggal}', [KepsekAbsensiController::class, 'create'])
             ->name('kepsek.absensi.create');
        Route::get('/spp', [KepsekSPPController::class, 'index'])
             ->name('kepsek.spp.index');
        Route::get('/spp/{tahun}/{bulan}', [KepsekSPPController::class, 'show'])
             ->name('kepsek.spp.show');
        Route::get('/keuangan', [KepsekKeuanganController::class, 'index'])
             ->name('kepsek.keuangan.index');
        Route::post('/keuangan/export', [KepsekKeuanganController::class, 'export'])
             ->name('kepsek.keuangan.export');
        Route::get('/guru-tendik', [KepsekGuruController::class, 'index'])
             ->name('kepsek.guru.index');
        Route::get('/profile', [KepsekProfileController::class, 'index'])
             ->name('kepsek.profile.index');
        Route::put('/profile', [KepsekProfileController::class, 'update'])
             ->name('kepsek.profile.update');
    });

    // Rute Grup untuk Guru
    Route::middleware('role:guru')->prefix('guru')->group(function () {
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])
          ->name('guru.dashboard');
        Route::get('/charts/absensi', [GuruDashboardController::class, 'getAbsensiChartData'])
          ->name('guru.charts.absensi');
        Route::get('/data-siswa', [GuruSiswaController::class, 'index'])
          ->name('guru.siswa.index');
        Route::get('/absensi', [GuruAbsensiController::class, 'index'])
          ->name('guru.absensi.index');
        Route::get('/absensi/isi/{tanggal}', [GuruAbsensiController::class, 'create'])
          ->name('guru.absensi.create');
        Route::get('/profile', [GuruProfileController::class, 'index'])
          ->name('guru.profile.index');
        Route::put('/profile', [GuruProfileController::class, 'update'])
          ->name('guru.profile.update');
    });

    // Rute Grup untuk Bendahara
    Route::middleware('role:bendahara')->prefix('bendahara')->group(function () {
        Route::get('/dashboard', [BendaharaDashboardController::class, 'index'])
          ->name('bendahara.dashboard');
        Route::get('/profile', [BendaharaProfileController::class, 'index'])
          ->name('bendahara.profile.index');
        Route::get('/spp', [BendaharaSPPController::class, 'index'])
          ->name('bendahara.spp.index');
        Route::get('/spp/{tahun}/{bulan}', [BendaharaSPPController::class, 'show'])
          ->name('bendahara.spp.show');
        Route::get('/keuangan', [BendaharaKeuanganController::class, 'index'])
          ->name('bendahara.keuangan.index');
        Route::post('/keuangan/export', [BendaharaKeuanganController::class, 'export'])
          ->name('bendahara.keuangan.export');
        Route::put('/profile', [BendaharaProfileController::class, 'update'])
          ->name('bendahara.profile.update');
        Route::get('/charts/keuangan', [BendaharaDashboardController::class, 'getKeuanganChartData'])
          ->name('bendahara.charts.keuangan');
    });

    // Rute Grup untuk Operator
    Route::middleware('role:operator')->prefix('operator')->group(function () {
        Route::get('/dashboard', [OperatorDashboardController::class, 'index'])
             ->name('operator.dashboard');
        Route::get('/charts/siswa', [OperatorDashboardController::class, 'getSiswaChartData'])
             ->name('operator.charts.siswa');
        Route::get('/data-siswa', [OperatorSiswaController::class, 'index'])
             ->name('operator.siswa.index');
        Route::get('/guru-tendik', [OperatorGuruController::class, 'index'])
             ->name('operator.guru.index');
        Route::get('/profile', [OperatorProfileController::class, 'index'])
             ->name('operator.profile.index');
        Route::put('/profile', [OperatorProfileController::class, 'update'])
             ->name('operator.profile.update');
    });

});