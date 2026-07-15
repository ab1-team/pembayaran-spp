<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('sub_laporans')->truncate();
        DB::table('sub_laporans')->insert([
            ['id' => 1, 'nama_laporan' => 'Neraca',            'file' => 'neraca_tutup_buku',     'urut' => 1, 'id_lap' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nama_laporan' => 'Laba Rugi',         'file' => 'laba_rugi_tutup_buku',  'urut' => 2, 'id_lap' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nama_laporan' => 'CALK',              'file' => 'CALK_tutup_buku',       'urut' => 3, 'id_lap' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'nama_laporan' => 'Jurnal Tutup Buku', 'file' => 'jurnal_tutup_buku',     'urut' => 4, 'id_lap' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'nama_laporan' => 'Alokasi Laba',      'file' => 'alokasi_laba',          'urut' => 5, 'id_lap' => 0, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
