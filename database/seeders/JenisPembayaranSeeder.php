<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Pembayaran SPP', '4.1.01.01', '250000'],
            ['Daftar Ulang', '4.1.01.02', '100000'],
            ['Pembangunan', '4.1.01.03', '100000'],
            ['Ujian Semester', '4.1.01.04', '100000'],
            ['Ahirussanah/Wisuda', '4.1.01.05', '100000'],
        ];

        $data = [];
        foreach ($rows as $i => $r) {
            $data[] = [
                'id' => $i + 1,
                'nama' => $r[0],
                'kode_akun' => $r[1],
                'jumlah' => $r[2],
                'created_at' => '2026-07-16 07:24:53',
                'updated_at' => null,
            ];
        }

        DB::table('jenis_pembayaran')->insertOrIgnore($data);
    }
}
