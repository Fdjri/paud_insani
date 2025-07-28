<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\KeuanganExport; 
use Maatwebsite\Excel\Facades\Excel; 

class KeuanganController extends Controller
{
    public function index()
    {
        return view('kepsek.keuangan.index');
    }

    /**
     * Method baru untuk menangani ekspor data.
     */
    public function export(Request $request)
    {
        $request->validate([
            'tipe_ekspor' => 'required|in:perbulan,pertahun',
            'bulan' => 'required_if:tipe_ekspor,perbulan|integer|between:1,12',
            'tahun_bulan' => 'required_if:tipe_ekspor,perbulan|integer|digits:4',
            'tahun' => 'required_if:tipe_ekspor,pertahun|integer|digits:4',
        ]);
        
        $tipe = $request->tipe_ekspor;
        $fileName = 'Laporan Keuangan ';

        if ($tipe == 'perbulan') {
            $tahun = $request->tahun_bulan;
            $bulan = $request->bulan;
            $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
            $fileName .= "{$namaBulan} {$tahun}.xlsx";
            return Excel::download(new KeuanganExport($tahun, $bulan), $fileName);
        }

        if ($tipe == 'pertahun') {
            $tahun = $request->tahun;
            $fileName .= "Tahun {$tahun}.xlsx";
            return Excel::download(new KeuanganExport($tahun), $fileName);
        }
    }
}