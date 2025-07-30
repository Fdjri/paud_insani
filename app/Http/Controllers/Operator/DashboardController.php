<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menyiapkan dan menampilkan halaman dasbor utama untuk Operator.
     */
    public function index()
    {
        // --- Data untuk Kartu Statistik ---
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $totalGuru = User::where('role', 'guru')->count();
        // Asumsi Tendik adalah Operator dan Bendahara
        $totalTendik = User::whereIn('role', ['operator', 'bendahara'])->count();

        // Kirim semua data yang diperlukan ke view
        return view('operator.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalTendik'
        ));
    }

    /**
     * Menyediakan data pendaftaran siswa per tahun untuk grafik via AJAX.
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
}