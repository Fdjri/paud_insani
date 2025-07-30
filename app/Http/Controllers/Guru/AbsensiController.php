<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Menampilkan halaman kalender
    public function index()
    {
        return view('guru.absensi.index');
    }

    // Menampilkan halaman pengisian absensi
    public function create($tanggal)
    {
        return view('guru.absensi.create', compact('tanggal'));
    }
}