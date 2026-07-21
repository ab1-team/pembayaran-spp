<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunLevel2Seeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [1, 0, 1, 0, 0, '1.1.00.00', 'Aset Lancar', 'debet'],
            [2, 0, 1, 0, 0, '1.2.00.00', 'Aset Tidak Lancar', 'debet'],
            [3, 0, 1, 0, 0, '1.3.00.00', 'Aset Lain-lain', 'debet'],
            [4, 0, 2, 0, 0, '2.1.00.00', 'Utang Jangka Pendek', 'kredit'],
            [5, 0, 2, 0, 0, '2.2.00.00', 'Utang Jangka Panjang', 'kredit'],
            [6, 0, 3, 0, 0, '3.1.00.00', 'Modal Disetor', 'kredit'],
            [7, 0, 3, 0, 0, '3.2.00.00', 'Laba Rugi', 'kredit'],
            [8, 0, 4, 0, 0, '4.1.00.00', 'Pendapatan Usaha', 'kredit'],
            [9, 0, 4, 0, 0, '4.2.00.00', 'Pendapatan Non Usaha', 'kredit'],
            [10, 0, 4, 0, 0, '4.3.00.00', 'Pendapatan Luar Biasa', 'kredit'],
            [11, 0, 5, 0, 0, '5.1.00.00', 'Beban Usaha', 'debet'],
            [12, 0, 5, 0, 0, '5.2.00.00', 'Beban Pemasaran', 'debet'],
            [13, 0, 5, 0, 0, '5.3.00.00', 'Beban Non Usaha', 'debet'],
            [14, 0, 5, 0, 0, '5.4.00.00', 'Beban Pajak', 'debet'],
        ];

        $data = [];
        foreach ($rows as $i => $r) {
            $data[] = [
                'id' => $i + 1,
                'parent_id' => $r[0],
                'lev1' => $r[1],
                'lev2' => $r[2],
                'lev3' => $r[3],
                'lev4' => 0,
                'kode_akun' => $r[4],
                'nama_akun' => $r[5],
                'jenis_mutasi' => $r[6],
                'created_at' => '2026-07-14 22:29:57',
                'updated_at' => '2026-07-14 22:29:57',
            ];
        }

        DB::table('akun_level2')->insertOrIgnore($data);
    }
}
