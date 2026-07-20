<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE spp s
            JOIN anggota_kelas ak ON ak.id = s.anggota_kelas
            SET s.kode = CONCAT(DATE_FORMAT(s.tanggal, '%y%m'), ak.id_siswa)
            WHERE s.kode IS NULL OR s.kode = ''
        ");

        DB::statement("
            UPDATE transaksi t
            JOIN spp s ON s.id = CAST(t.kode_spp AS UNSIGNED)
            SET t.kode_spp = s.kode
            WHERE t.kode_spp IS NOT NULL AND t.kode_spp <> ''
        ");
    }

    public function down(): void
    {
        DB::statement("
            UPDATE transaksi t
            JOIN spp s ON s.kode = t.kode_spp
            SET t.kode_spp = s.id
            WHERE t.kode_spp IS NOT NULL AND t.kode_spp <> ''
        ");

        DB::statement("UPDATE spp SET kode = NULL WHERE kode IS NOT NULL");
    }
};
