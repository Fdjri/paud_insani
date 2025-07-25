<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Pembayaran;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 200 siswa menggunakan factory
        Siswa::factory()->count(200)->create()->each(function ($siswa) {
            // Untuk setiap siswa yang dibuat, buat juga data absensi & pembayaran

            // 1. Buat data absensi untuk 3 bulan terakhir
            $tanggal = Carbon::now()->subMonths(3);
            for ($i = 0; $i < 90; $i++) {
                $tanggal->addDay();
                // Lewati hari Sabtu (6) dan Minggu (0)
                if ($tanggal->dayOfWeek != 0 && $tanggal->dayOfWeek != 6) {
                    Absensi::create([
                        'siswa_id' => $siswa->id,
                        'tanggal_absensi' => $tanggal->format('Y-m-d'),
                        'status' => fake()->randomElement(['Hadir', 'Hadir', 'Hadir', 'Hadir', 'Sakit', 'Izin']),
                    ]);
                }
            }

            // 2. Buat data pembayaran untuk 3 bulan terakhir
            for ($i = 0; $i < 3; $i++) {
                $bulan = Carbon::now()->subMonths($i);
                Pembayaran::create([
                    'siswa_id' => $siswa->id,
                    'jenis_pembayaran' => 'SPP',
                    'tahun_ajaran' => $bulan->year,
                    'bulan_pembayaran' => $bulan->format('F'), // e.g., 'July'
                    'jumlah_bayar' => 300000,
                    'tanggal_bayar' => $bulan->startOfMonth()->addDays(rand(5, 10))->format('Y-m-d'),
                    'status' => 'Lunas'
                ]);
            }
        });
    }
}