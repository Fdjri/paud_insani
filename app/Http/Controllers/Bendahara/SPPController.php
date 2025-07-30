<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SPPController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->query('tahun', now()->year);
        // DIUBAH: Arahkan ke view bendahara
        return view('bendahara.spp.index', compact('tahun'));
    }

    public function show($tahun, $bulan)
    {
        // DIUBAH: Arahkan ke view bendahara
        return view('bendahara.spp.show', [
            'tahun' => (int) $tahun,
            'bulan' => (int) $bulan,
        ]);
    }
}