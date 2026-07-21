<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunLevel1Seeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [1, 0, 0, 0, '1.0.00.00', 'Aset', 'debet'],
            [2, 0, 0, 0, '2.0.00.00', 'Utang', 'kredit'],
            [3, 0, 0, 0, '3.0.00.00', 'Modal', 'kredit'],
            [4, 0, 0, 0, '4.0.00.00', 'Pendapatan', 'kredit'],
            [5, 0, 0, 0, '5.0.00.00', 'Beban', 'debet'],
        ];

        $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'id' => $r[0],
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

        DB::table('akun_level1')->insertOrIgnore($data);
    }
}
