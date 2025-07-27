<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('kepsek.absensi.index'); // Hanya menampilkan view
    }

    public function create($tanggal)
    {
        return view('kepsek.absensi.create', compact('tanggal'));
    }
}