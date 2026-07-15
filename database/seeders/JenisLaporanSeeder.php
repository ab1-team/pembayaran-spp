<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisLaporanSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('jenis_laporan')->exists()) {
            return;
        }

        $now = now();

        DB::table('jenis_laporan')->insert([
            ['nama' => 'Cover',                'file' => 'cover',           'urut' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Jurnal Transaksi',     'file' => 'jurnal_transaksi','urut' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Buku Besar',           'file' => 'buku_besar',      'urut' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Neraca Saldo',         'file' => 'neraca_saldo',    'urut' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Laba Rugi',            'file' => 'laba_rugi',       'urut' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Neraca',               'file' => 'neraca',          'urut' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Arus Kas',             'file' => 'arus_kas',        'urut' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Catatan Atas Laporan Keuangan', 'file' => 'calk',   'urut' => 8, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
