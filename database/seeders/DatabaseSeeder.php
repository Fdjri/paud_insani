<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KelasSeeder::class,
            UserSeeder::class,
            SiswaSeeder::class,
            KeuanganSeeder::class,
        ]);
    }
}