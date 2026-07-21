<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubLaporansSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Neraca', 'neraca_tutup_buku', 1],
            ['Laba Rugi', 'laba_rugi_tutup_buku', 2],
            ['CALK', 'CALK_tutup_buku', 3],
            ['Jurnal Tutup Buku', 'jurnal_tutup_buku', 4],
            ['Alokasi Laba', 'alokasi_laba', 5],
        ];

        $data = [];
        foreach ($rows as $i => $r) {
            $data[] = [
                'id' => $i + 1,
                'nama_laporan' => $r[0],
                'file' => $r[1],
                'urut' => $r[2],
                'id_lap' => 0,
                'created_at' => null,
                'updated_at' => null,
            ];
        }

        DB::table('sub_laporans')->insertOrIgnore($data);
    }
}
