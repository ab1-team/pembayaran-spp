<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPembayaranSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('jenis_pembayaran')->exists()) {
            return;
        }

        DB::table('jenis_pembayaran')->insert([
            ['id' => 1, 'nama' => 'Pembayaran SPP', 'kode_akun' => '4.1.01.01', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Daftar Ulang',  'kode_akun' => '1.1.03.01', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Pembangunan',    'kode_akun' => '4.1.01.04', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Ujian Semester', 'kode_akun' => '4.1.01.03', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nama' => 'Bantuan Yayasan','kode_akun' => '4.1.01.05', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
