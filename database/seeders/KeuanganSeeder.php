<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keuangan;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $tipe = fake()->randomElement(['pemasukan', 'pengeluaran']);
            Keuangan::create([
                'deskripsi' => fake()->sentence(3),
                'tipe' => $tipe,
                'tanggal' => fake()->dateTimeBetween('-1 year', 'now'),
                'jumlah' => rand(1, 5),
                'biaya' => fake()->randomFloat(2, 50000, 1000000),
            ]);
        }
    }
}