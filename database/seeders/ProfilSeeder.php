<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        $exists = DB::table('profil')->exists();
        if ($exists) {
            return;
        }

        DB::table('profil')->insert([
            'nama'       => 'PAMSIDES Tirto Mulo',
            'alamat'     => 'Desa Sonosari, Kecamatan Karangmalang, Kabupaten Sragen',
            'telpon'     => '08123456789',
            'email'      => 'admin@tirtomulo.desa.id',
            'penanggung_jawab' => 'Direktur Utama',
            'logo'       => null,
            'jatuh_tempo' => 26,
            'status_pembayaran' => 1,
            'toleransi_tunggakan' => 3,
            'pesan_tagihan' => 'Yth. {customer}, tagihan bulan ini sebesar {jumlah_tagihan}. Mohon segera melakukan pembayaran sebelum jatuh tempo.',
            'pesan_pembayaran' => 'Yth. {customer}, pembayaran sebesar {tagihan} telah kami terima.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
