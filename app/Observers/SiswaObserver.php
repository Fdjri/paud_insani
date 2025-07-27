<?php

namespace App\Observers;

use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;

class SiswaObserver
{
    /**
     * Menangani event "creating" pada model Siswa.
     */
    public function creating(Siswa $siswa): void
    {
        // Panggil fungsi untuk menentukan kelas berdasarkan umur
        // hanya jika kelas_id belum diisi manual
        if (empty($siswa->kelas_id)) {
            $this->setKelasByAge($siswa);
        }
    }

    /**
     * Fungsi untuk menghitung umur dan menentukan kelas.
     */
    protected function setKelasByAge(Siswa $siswa): void
    {
        if ($siswa->tanggal_lahir) {
            $tanggalLahir = Carbon::parse($siswa->tanggal_lahir);
            $umurBulan = $tanggalLahir->diffInMonths(now());
            
            // Konversi rentang usia ke bulan
            $batasUsiaKelasA_awal = 4 * 12; // 48 bulan
            $batasUsiaKelasA_akhir = (5 * 12) + 6; // 66 bulan
            $batasUsiaKelasB_akhir = 7 * 12; // 84 bulan
            
            $namaKelasTarget = null;

            // Logika untuk Kelas A: 4 tahun (>= 48 bln) hingga 5 tahun 6 bulan (< 66 bln)
            if ($umurBulan >= $batasUsiaKelasA_awal && $umurBulan < $batasUsiaKelasA_akhir) {
                $namaKelasTarget = 'A';
            } 
            // Logika untuk Kelas B: 5 tahun 6 bulan (>= 66 bln) hingga 7 tahun (< 84 bln)
            elseif ($umurBulan >= $batasUsiaKelasA_akhir && $umurBulan < $batasUsiaKelasB_akhir) {
                $namaKelasTarget = 'B';
            }
            
            if ($namaKelasTarget) {
                $kelas = Kelas::where('nama_kelas', $namaKelasTarget)->first();
                if ($kelas) {
                    $siswa->kelas_id = $kelas->id;
                }
            }
        }
    }
}