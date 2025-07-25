<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::updateOrCreate(['nama_kelas' => 'A']);
        Kelas::updateOrCreate(['nama_kelas' => 'B']);
    }
}