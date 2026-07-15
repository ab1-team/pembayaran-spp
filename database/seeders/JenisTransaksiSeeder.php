<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('jenis_transaksi')->exists()) {
            return;
        }

        $now = now();

        DB::table('jenis_transaksi')->insert([
            ['id' => 1, 'nama' => 'Aset Masuk',      'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nama' => 'Aset Keluar',     'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nama' => 'Pemindahan Saldo', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
