<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn("Menghapus data lama dari tabel siswa, absensi, dan pembayaran...");
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Siswa::truncate();
        Absensi::truncate();
        Pembayaran::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info("Data lama berhasil dihapus.");

        Siswa::flushEventListeners();

        $this->command->getOutput()->progressStart(1001);

        Siswa::factory()->count(1001)->create()->each(function ($siswa) {
            $tanggalAbsensi = Carbon::now();
            for ($i = 0; $i < 90; $i++) {
                if (!$tanggalAbsensi->isWeekend()) {
                    Absensi::create([
                        'siswa_id' => $siswa->id,
                        'tanggal_absensi' => $tanggalAbsensi->format('Y-m-d'),
                        'status' => fake()->randomElement(['Hadir', 'Hadir', 'Hadir', 'Sakit', 'Izin', 'Alpa']),
                    ]);
                }
                $tanggalAbsensi->subDay();
            }

            for ($i = 0; $i < 12; $i++) {
                $bulanPembayaran = Carbon::now()->subMonths($i);
                Pembayaran::create([
                    'siswa_id' => $siswa->id,
                    'user_id' => \App\Models\User::where('role', 'bendahara')->inRandomOrder()->first()->id,
                    'jenis_pembayaran' => 'SPP',
                    'tahun_ajaran' => $bulanPembayaran->year,
                    'bulan_pembayaran' => $bulanPembayaran->translatedFormat('F'),
                    'jumlah_bayar' => 300000,
                    'tanggal_bayar' => $bulanPembayaran->startOfMonth()->addDays(rand(5, 15))->format('Y-m-d'),
                    'status' => 'Lunas'
                ]);
            }
            $this->command->getOutput()->progressAdvance();
        });

        $this->command->getOutput()->progressFinish();
    }
}