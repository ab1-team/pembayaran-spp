<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('profil')->insertOrIgnore([
            [
                'id' => 1,
                'nama' => "SDIT Al Ma'ruf Tegalrejo",
                'alamat' => 'Jalan PLN Tegalrejo Magelang 56192',
                'telpon' => '(0293) 314895',
                'penanggung_jawab' => 'Kepala Sekolah',
                'email' => "admin@ Al Ma'ruf.id",
                'logo' => 'uH6KZzhqv27obZkT10tK5VJsJxAuadrnU89rMgSp.jpg',
                'jatuh_tempo' => 1,
                'created_at' => '2026-07-14 22:29:57',
                'updated_at' => '2026-07-19 18:33:06',
            ],
        ]);
    }
}
