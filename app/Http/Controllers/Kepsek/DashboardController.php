<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Data untuk Kartu Statistik ---
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $totalGuru = User::where('role', 'guru')->count();
        // Asumsi Tendik adalah Operator dan Bendahara
        $totalTendik = User::whereIn('role', ['operator', 'bendahara'])->count();
        
        $pemasukan = Keuangan::where('tipe', 'pemasukan')->sum('biaya');
        $pengeluaran = Keuangan::where('tipe', 'pengeluaran')->sum('biaya');
        $totalDana = $pemasukan - $pengeluaran;


        // --- Data untuk Grafik Keuangan (12 bulan terakhir) ---
        $keuanganData = Keuangan::select(
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw("SUM(CASE WHEN tipe = 'pemasukan' THEN biaya ELSE 0 END) as total_pemasukan"),
            DB::raw("SUM(CASE WHEN tipe = 'pengeluaran' THEN biaya ELSE 0 END) as total_pengeluaran")
        )
        ->whereYear('tanggal', date('Y'))
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun', 'asc')
        ->orderBy('bulan', 'asc')
        ->get();

        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $dataPemasukan = array_fill(0, 12, 0);
        $dataPengeluaran = array_fill(0, 12, 0);
        
        foreach ($keuanganData as $data) {
            $dataPemasukan[$data->bulan - 1] = $data->total_pemasukan;
            $dataPengeluaran[$data->bulan - 1] = $data->total_pengeluaran;
        }


        // --- Kirim semua data ke view ---
        return view('kepsek.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalTendik',
            'totalDana',
            'namaBulan',
            'dataPemasukan',
            'dataPengeluaran'
        ));
    }
}