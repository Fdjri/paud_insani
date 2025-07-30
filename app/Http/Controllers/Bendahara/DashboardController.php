<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total dana keseluruhan
        $pemasukan = Keuangan::where('tipe', 'pemasukan')->sum(DB::raw('jumlah * biaya'));
        $pengeluaran = Keuangan::where('tipe', 'pengeluaran')->sum(DB::raw('jumlah * biaya'));
        $totalDana = $pemasukan - $pengeluaran;

        // --- LOGIKA BARU UNTUK PERBANDINGAN BULANAN ---
        $bulanIni = Carbon::now();
        $bulanLalu = Carbon::now()->subMonth();

        // Dana bulan ini
        $pemasukanBulanIni = Keuangan::where('tipe', 'pemasukan')->whereYear('tanggal', $bulanIni->year)->whereMonth('tanggal', $bulanIni->month)->sum(DB::raw('jumlah * biaya'));
        $pengeluaranBulanIni = Keuangan::where('tipe', 'pengeluaran')->whereYear('tanggal', $bulanIni->year)->whereMonth('tanggal', $bulanIni->month)->sum(DB::raw('jumlah * biaya'));
        $totalDanaBulanIni = $pemasukanBulanIni - $pengeluaranBulanIni;

        // Dana bulan lalu
        $pemasukanBulanLalu = Keuangan::where('tipe', 'pemasukan')->whereYear('tanggal', $bulanLalu->year)->whereMonth('tanggal', $bulanLalu->month)->sum(DB::raw('jumlah * biaya'));
        $pengeluaranBulanLalu = Keuangan::where('tipe', 'pengeluaran')->whereYear('tanggal', $bulanLalu->year)->whereMonth('tanggal', $bulanLalu->month)->sum(DB::raw('jumlah * biaya'));
        $totalDanaBulanLalu = $pemasukanBulanLalu - $pengeluaranBulanLalu;

        // Hitung persentase perubahan
        $persentasePerbandingan = 0;
        if ($totalDanaBulanLalu != 0) {
            $persentasePerbandingan = (($totalDanaBulanIni - $totalDanaBulanLalu) / abs($totalDanaBulanLalu)) * 100;
        } elseif ($totalDanaBulanIni > 0) {
            $persentasePerbandingan = 100; // Jika bulan lalu 0 dan bulan ini positif
        }
        
        $trenPerbandingan = $totalDanaBulanIni >= $totalDanaBulanLalu ? 'naik' : 'turun';
        // --- AKHIR LOGIKA BARU ---

        return view('bendahara.dashboard', compact(
            'totalDana',
            'pemasukan',
            'pengeluaran',
            'persentasePerbandingan',
            'trenPerbandingan'
        ));
    }

    public function getKeuanganChartData(Request $request)
    {
        // Logika untuk menyediakan data chart via AJAX
        $tahun = $request->query('tahun', date('Y'));

        $keuanganData = Keuangan::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw("SUM(CASE WHEN tipe = 'pemasukan' THEN biaya * jumlah ELSE 0 END) as total_pemasukan"),
            DB::raw("SUM(CASE WHEN tipe = 'pengeluaran' THEN biaya * jumlah ELSE 0 END) as total_pengeluaran")
        )
        ->whereYear('tanggal', $tahun)
        ->groupBy('bulan')
        ->orderBy('bulan', 'asc')
        ->get();

        $dataPemasukan = array_fill(0, 12, 0);
        $dataPengeluaran = array_fill(0, 12, 0);
        
        foreach ($keuanganData as $data) {
            $dataPemasukan[$data->bulan - 1] = (int) $data->total_pemasukan;
            $dataPengeluaran[$data->bulan - 1] = (int) $data->total_pengeluaran;
        }

        return response()->json([
            'pemasukan' => $dataPemasukan,
            'pengeluaran' => $dataPengeluaran,
        ]);
    }
}