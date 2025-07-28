<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SPPController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->query('tahun', now()->year);
        return view('kepsek.spp.index', compact('tahun'));
    }

    public function show($tahun, $bulan)
    {
        // PERUBAHAN DI SINI: Ubah tipe data menjadi integer
        return view('kepsek.spp.show', [
            'tahun' => (int) $tahun,
            'bulan' => (int) $bulan,
        ]);
    }
}