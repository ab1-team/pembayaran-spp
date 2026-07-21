<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAkademikSeeder extends Seeder
{
    public function run(): void
    {
        $now = null;
        $rows = [
            [1, '2017/2018', 'Semester Ganjil/Genap', 'aktif'],
            [2, '2018/2019', 'Semester Ganjil/Genap', 'aktif'],
            [3, '2019/2020', 'Semester Ganjil/Genap', 'aktif'],
            [4, '2020/2021', 'Semester Ganjil/Genap', 'aktif'],
            [5, '2021/2022', 'Semester Ganjil/Genap', 'aktif'],
            [6, '2022/2023', 'Semester Ganjil/Genap', 'aktif'],
            [7, '2023/2024', 'Semester Ganjil/Genap', 'aktif'],
            [8, '2024/2025', 'Semester Ganjil/Genap', 'aktif'],
            [9, '2025/2026', 'Semester Ganjil/Genap', 'aktif'],
            [10, '2026/2027', 'Semester Ganjil/Genap', 'aktif'],
        ];

        $data = array_map(function ($r) {
            return [
                'id' => $r[0],
                'nama_tahun' => $r[1],
                'keterangan' => $r[2],
                'status' => $r[3],
                'created_at' => null,
                'updated_at' => null,
            ];
        }, $rows);

        DB::table('tahun_akademik')->insertOrIgnore($data);
    }
}
