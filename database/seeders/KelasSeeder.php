<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['I.A', 'Kelas I.A', 'I'],
            ['I.B', 'Kelas I.B', 'I'],
            ['I.C', 'Kelas I.C', 'I'],
            ['I.D', 'Kelas I.D', 'I'],
            ['I.E', 'Kelas I.E', 'I'],
            ['II.A', 'Kelas II.A', 'II'],
            ['II.B', 'Kelas II.B', 'II'],
            ['II.C', 'Kelas II.C', 'II'],
            ['II.D', 'Kelas II.D', 'II'],
            ['III.A', 'Kelas III.A', 'III'],
            ['III.B', 'Kelas III.B', 'III'],
            ['III.C', 'Kelas III.C', 'III'],
            ['III.D', 'Kelas III.D', 'III'],
            ['IV.A', 'Kelas IV.A', 'IV'],
            ['IV.B', 'Kelas IV.B', 'IV'],
            ['IV.C', 'Kelas IV.C', 'IV'],
            ['IV.D', 'Kelas IV.D', 'IV'],
            ['V.A', 'Kelas V.A', 'V'],
            ['V.B', 'Kelas V.B', 'V'],
            ['V.C', 'Kelas V.C', 'V'],
            ['V.D', 'Kelas V.D', 'V'],
            ['VI.A', 'Kelas VI.A', 'VI'],
            ['VI.B', 'Kelas VI.B', 'VI'],
            ['VI.C', 'Kelas VI.C', 'VI'],
            ['VI.D', 'Kelas VI.D', 'VI'],
        ];

        $data = [];
        foreach ($rows as $i => $r) {
            $data[] = [
                'id' => $i + 1,
                'kode_kelas' => $r[0],
                'nama_kelas' => $r[1],
                'tingkat' => $r[2],
                'kode_kurikulum' => 'K-MERDEKA',
                'created_at' => null,
                'updated_at' => null,
            ];
        }

        DB::table('kelas')->insertOrIgnore($data);
    }
}
