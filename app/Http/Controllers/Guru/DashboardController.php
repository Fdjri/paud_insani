<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelasWali = $user->kelas;
        $siswas = $kelasWali ? Siswa::where('kelas_id', $kelasWali->id)->where('status', 'aktif')->get() : collect();
        $totalSiswa = $siswas->count();

        return view('guru.dashboard', compact('totalSiswa', 'siswas', 'kelasWali'));
    }

    /**
     * Menyediakan data rekap absensi untuk grafik via AJAX.
     */
    public function getAbsensiChartData(Request $request)
    {
        $user = Auth::user();
        $kelasWali = $user->kelas;

        if (!$kelasWali) {
            return response()->json(['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpa' => 0]);
        }

        $bulan = $request->query('bulan', now()->month);
        $tahun = $request->query('tahun', now()->year);

        $rekap = Absensi::whereYear('tanggal_absensi', $tahun)
            ->whereMonth('tanggal_absensi', $bulan)
            ->whereIn('siswa_id', $kelasWali->siswa->pluck('id'))
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'hadir' => $rekap->get('Hadir', 0),
            'sakit' => $rekap->get('Sakit', 0),
            'izin' => $rekap->get('Izin', 0),
            'alpa' => $rekap->get('Alpa', 0),
        ]);
    }
}