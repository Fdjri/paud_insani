<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        $jenisKelamin = $this->faker->randomElement(['Laki-laki', 'Perempuan']);
        $namaLengkap = $this->faker->name($jenisKelamin == 'Laki-laki' ? 'male' : 'female');
        $namaPanggilan = explode(' ', $namaLengkap)[0];
        
        $pendidikan = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];
        
        return [
            'nis' => $this->faker->unique()->numerify('1020#####'),
            'nik' => $this->faker->unique()->numerify('3201################'),
            'no_kk' => $this->faker->unique()->numerify('3201################'),
            'nama_lengkap' => $namaLengkap,
            'nama_panggilan' => $namaPanggilan,
            'jenis_kelamin' => $jenisKelamin,
            'tanggal_lahir' => $this->faker->dateTimeBetween('-7 years', '-4 years'),
            'agama' => 'Islam',
            'kewarganegaraan' => 'Indonesia',
            'anak_ke' => $this->faker->numberBetween(1, 5),
            'jumlah_saudara_kandung' => $this->faker->numberBetween(0, 4),
            'bahasa_sehari_hari' => 'Indonesia',
            'berat_badan' => $this->faker->randomFloat(1, 15, 25),
            'tinggi_badan' => $this->faker->randomFloat(1, 90, 120),
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'penyakit_yang_pernah_diderita' => $this->faker->randomElement([null, 'Asma', 'Alergi Debu', 'Cacar Air']),
            'alamat_tempat_tinggal' => $this->faker->address,
            'nomor_telp' => $this->faker->phoneNumber,
            'jarak_tempat_tinggal_ke_sekolah' => $this->faker->randomElement(['< 1 KM', '1-3 KM', '> 3 KM']),
            'nama_ayah_kandung' => $this->faker->name('male'),
            'pendidikan_ayah' => $this->faker->randomElement($pendidikan),
            'pekerjaan_ayah' => $this->faker->jobTitle,
            'nama_ibu_kandung' => $this->faker->name('female'),
            'pendidikan_ibu' => $this->faker->randomElement($pendidikan),
            'pekerjaan_ibu' => $this->faker->jobTitle,
            'tipe_murid' => 'Siswa Baru',
            'status' => 'aktif',
            'tahun_masuk' => $this->faker->numberBetween(date('Y') - 3, date('Y')),
        ];
    }
}