<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $data = [
            ['nama' => 'Laporan Cover',                     'file' => 'cover',           'urut' => 1],
            ['nama' => 'Laporan Jurnal Transaksi',          'file' => 'jurnal_transaksi','urut' => 2],
            ['nama' => 'Laporan Buku Besar',                'file' => 'buku_besar',      'urut' => 3],
            ['nama' => 'Laporan Neraca Saldo',              'file' => 'neraca_saldo',    'urut' => 4],
            ['nama' => 'Laporan Laba Rugi',                 'file' => 'laba_rugi',       'urut' => 5],
            ['nama' => 'Laporan Neraca',                    'file' => 'neraca',          'urut' => 6],
            ['nama' => 'Laporan Arus Kas',                  'file' => 'arus_kas',        'urut' => 7],
            ['nama' => 'Laporan CALK',                      'file' => 'calk',            'urut' => 8],
            ['nama' => 'Laporan Pembayaran SPP',            'file' => 'pembayaran_spp',  'urut' => 9],
            ['nama' => 'Laporan Pembayaran Daftar Ulang',   'file' => 'daftar_ulang',    'urut' => 10],
        ];

        foreach ($data as $row) {
            DB::table('jenis_laporan')->updateOrInsert(
                ['file' => $row['file']],
                $row + ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
