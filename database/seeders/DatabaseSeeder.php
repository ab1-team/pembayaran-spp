<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            ProfilSeeder::class,
            TandaTanganSeeder::class,
            RekeningSeeder::class,
            JenisTransaksiSeeder::class,
            JenisPembayaranSeeder::class,
            JenisLaporanSeeder::class,
            SiswaSeeder::class,
        ]);
    }
}
