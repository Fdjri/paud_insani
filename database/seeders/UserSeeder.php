<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Pengguna
        User::updateOrCreate(
            ['username' => 'kepsek'],
            [
                'nama' => 'Kepala Sekolah',
                'nik' => '1111111111111111',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1980-01-01',
                'role' => 'kepala sekolah',
            ]
        );

        User::updateOrCreate(
            ['username' => 'bendahara'],
            [
                'nama' => 'Bendahara Sekolah',
                'nik' => '2222222222222222',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1985-01-01',
                'role' => 'bendahara',
            ]
        );

        User::updateOrCreate(
            ['username' => 'operator'],
            [
                'nama' => 'Operator Sekolah',
                'nik' => '3333333333333333',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1990-01-01',
                'role' => 'operator',
            ]
        );

        $guruA = User::updateOrCreate(
            ['username' => 'gurukelasa'],
            [
                'nama' => 'Guru Kelas A',
                'nik' => '4444444444444444',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1992-01-01',
                'role' => 'guru',
            ]
        );

        $guruB = User::updateOrCreate(
            ['username' => 'gurukelasb'],
            [
                'nama' => 'Guru Kelas B',
                'nik' => '5555555555555555',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1993-01-01',
                'role' => 'guru',
            ]
        );
        
        // 2. Tetapkan Wali Kelas
        $kelasA = Kelas::where('nama_kelas', 'A')->first();
        if ($kelasA) {
            $kelasA->guru_id = $guruA->id;
            $kelasA->save();
        }

        $kelasB = Kelas::where('nama_kelas', 'B')->first();
        if ($kelasB) {
            $kelasB->guru_id = $guruB->id;
            $kelasB->save();
        }
    }
}