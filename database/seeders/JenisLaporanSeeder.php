<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Laporan Cover', 'cover', 1],
            ['Laporan Jurnal Transaksi', 'jurnal_transaksi', 2],
            ['Laporan Buku Besar', 'buku_besar', 3],
            ['Laporan Neraca Saldo', 'neraca_saldo', 4],
            ['Laporan Laba Rugi', 'laba_rugi', 5],
            ['Laporan Neraca', 'neraca', 6],
            ['Laporan Arus Kas', 'arus_kas', 7],
            ['Laporan CALK', 'calk', 8],
            ['Laporan Pembayaran SPP', 'pembayaran_spp', 9],
            ['Laporan Pembayaran Daftar Ulang', 'daftar_ulang', 10],
            ['Laporan Pembayaran Pembangunan', 'pembangunan', 11],
            ['Laporan Pembayaran Ujian Semester', 'ujian_semester', 12],
            ['Laporan Pembayaran Bantuan Yayasan', 'bantuan_yayasan', 13],
        ];

        $data = [];
        foreach ($rows as $i => $r) {
            $data[] = [
                'id' => $i + 1,
                'nama' => $r[0],
                'file' => $r[1],
                'urut' => $r[2],
                'created_at' => '2026-07-15 18:12:27',
                'updated_at' => '2026-07-15 18:12:27',
            ];
        }

        DB::table('jenis_laporan')->insertOrIgnore($data);
    }
}
