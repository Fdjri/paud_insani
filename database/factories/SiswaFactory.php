<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kelas;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        $kelasIds = Kelas::pluck('id')->toArray();
        $jenisKelamin = $this->faker->randomElement(['Laki-laki', 'Perempuan']);

        return [
            'nis' => $this->faker->unique()->numerify('##########'),
            'nik' => $this->faker->unique()->numerify('################'),
            'no_kk' => $this->faker->numerify('################'),
            'nama_lengkap' => $this->faker->name($jenisKelamin == 'Laki-laki' ? 'male' : 'female'),
            'jenis_kelamin' => $jenisKelamin,
            'tanggal_lahir' => $this->faker->dateTimeBetween('-7 years', '-4 years'),
            'agama' => 'Islam',
            'alamat_tempat_tinggal' => $this->faker->address,
            'nama_ayah_kandung' => $this->faker->name('male'),
            'pekerjaan_ayah' => $this->faker->jobTitle,
            'nama_ibu_kandung' => $this->faker->name('female'),
            'pekerjaan_ibu' => $this->faker->jobTitle,
            'tipe_murid' => 'Siswa Baru',
            'status' => 'aktif',
            'kelas_id' => $this->faker->randomElement($kelasIds),
        ];
    }
}