<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            AdminUserSeeder::class,
            ProfilSeeder::class,
            JabatanSeeder::class,
            TahunAkademikSeeder::class,
            KelasSeeder::class,
            RuanganSeeder::class,
            JenisPembayaranSeeder::class,
            JenisLaporanSeeder::class,
            SubLaporansSeeder::class,
            AkunLevel1Seeder::class,
            AkunLevel2Seeder::class,
            AkunLevel3Seeder::class,
            RekeningSeeder::class,
            AdminRekeningSeeder::class,
            AdminTransaksiSeeder::class,
            AdminInvoiceSeeder::class,
            MenuSeeder::class,
            MenuStructureSeeder::class,
            TandaTanganSeeder::class,
        ]);
    }
}