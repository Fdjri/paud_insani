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
    /**
     * Menyiapkan data kartu statistik untuk halaman dasbor.
     */
    public function index()
    {
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalTendik = User::whereIn('role', ['operator', 'bendahara'])->count();
        
        $pemasukan = Keuangan::where('tipe', 'pemasukan')->sum(DB::raw('jumlah * biaya'));
        $pengeluaran = Keuangan::where('tipe', 'pengeluaran')->sum(DB::raw('jumlah * biaya'));
        $totalDana = $pemasukan - $pengeluaran;
        
        return view('kepsek.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalTendik',
            'totalDana'
        ));
    }

    /**
     * Menyediakan data pendaftaran siswa per tahun untuk grafik.
     */
    public function getSiswaChartData(Request $request)
    {
        $namaKelas = $request->query('kelas');

        $query = Siswa::select(
                DB::raw('tahun_masuk as tahun'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereNotNull('tahun_masuk');

        if ($namaKelas && $namaKelas !== 'semua') {
            $query->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                  ->where('kelas.nama_kelas', $namaKelas);
        }
        
        $pendaftaranPerTahun = $query->groupBy('tahun')->orderBy('tahun', 'asc')->get()->pluck('jumlah', 'tahun');
        
        // Buat rentang tahun dari data yang ada
        $minYear = $pendaftaranPerTahun->keys()->min() ?? date('Y');
        $maxYear = $pendaftaranPerTahun->keys()->max() ?? date('Y');
        $labels = range($minYear, $maxYear);
        
        $data = array_map(function($year) use ($pendaftaranPerTahun) {
            return $pendaftaranPerTahun->get($year, 0);
        }, $labels);

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Menyediakan data keuangan per bulan untuk grafik.
     */
    public function getKeuanganChartData(Request $request)
    {
        $tahun = $request->query('tahun', date('Y')); // Ambil tahun dari filter, default tahun ini

        $keuanganData = Keuangan::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw("SUM(CASE WHEN tipe = 'pemasukan' THEN biaya ELSE 0 END) as total_pemasukan"),
            DB::raw("SUM(CASE WHEN tipe = 'pengeluaran' THEN biaya ELSE 0 END) as total_pengeluaran")
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