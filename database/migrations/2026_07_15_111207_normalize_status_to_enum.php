<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("UPDATE siswa SET status_siswa = LOWER(status_siswa)");
        DB::statement("UPDATE siswa SET status_awal = LOWER(REPLACE(status_awal, ' ', '_'))");
        DB::statement("UPDATE siswa SET jenis_tinggal = LOWER(REPLACE(jenis_tinggal, ' ', '_'))");
        DB::statement("UPDATE siswa SET jenis_kelamin = UPPER(jenis_kelamin)");
        DB::statement("UPDATE anggota_kelas SET status = LOWER(status)");
        DB::statement("UPDATE jurusan SET status = CASE WHEN status = 'A' THEN 'aktif' WHEN status = 'N' THEN 'nonaktif' ELSE status END");
        DB::statement("UPDATE kurikulum SET status = CASE WHEN status = 'A' THEN 'aktif' WHEN status = 'N' THEN 'nonaktif' ELSE status END");
        DB::statement("UPDATE tahun_akademik SET status = CASE WHEN status = 'A' THEN 'aktif' WHEN status = 'N' THEN 'nonaktif' ELSE status END");
        DB::statement("UPDATE akun_level1 SET jenis_mutasi = LOWER(jenis_mutasi)");
        DB::statement("UPDATE akun_level2 SET jenis_mutasi = LOWER(jenis_mutasi)");
        DB::statement("UPDATE akun_level3 SET jenis_mutasi = LOWER(jenis_mutasi)");
        DB::statement("UPDATE rekening SET jenis_mutasi = LOWER(jenis_mutasi)");

        DB::statement("ALTER TABLE siswa MODIFY status_siswa ENUM('aktif','nonaktif','blokir') NOT NULL DEFAULT 'aktif'");
        DB::statement("ALTER TABLE siswa MODIFY status_awal ENUM('baru','pindahan') NOT NULL DEFAULT 'baru'");
        DB::statement("ALTER TABLE siswa MODIFY jenis_kelamin ENUM('L','P') NOT NULL");
        DB::statement("ALTER TABLE siswa MODIFY jenis_tinggal ENUM('orang_tua','asrama','kost','wali') NOT NULL DEFAULT 'orang_tua'");

        DB::statement("ALTER TABLE anggota_kelas MODIFY status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif'");
        DB::statement("ALTER TABLE jurusan MODIFY status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif'");
        DB::statement("ALTER TABLE kurikulum MODIFY status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif'");
        DB::statement("ALTER TABLE tahun_akademik MODIFY status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'nonaktif'");

        DB::statement("ALTER TABLE akun_level1 MODIFY jenis_mutasi ENUM('debet','kredit') NOT NULL DEFAULT 'debet'");
        DB::statement("ALTER TABLE akun_level2 MODIFY jenis_mutasi ENUM('debet','kredit') NOT NULL DEFAULT 'debet'");
        DB::statement("ALTER TABLE akun_level3 MODIFY jenis_mutasi ENUM('debet','kredit') NOT NULL DEFAULT 'debet'");
        DB::statement("ALTER TABLE rekening MODIFY jenis_mutasi ENUM('debet','kredit') NOT NULL DEFAULT 'debet'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE siswa MODIFY status_siswa VARCHAR(255) NOT NULL DEFAULT 'Aktif'");
        DB::statement("ALTER TABLE siswa MODIFY status_awal VARCHAR(255) NOT NULL DEFAULT 'Baru'");
        DB::statement("ALTER TABLE siswa MODIFY jenis_kelamin VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE siswa MODIFY jenis_tinggal VARCHAR(255) NOT NULL DEFAULT 'Orang Tua'");

        DB::statement("ALTER TABLE anggota_kelas MODIFY status VARCHAR(255) NOT NULL DEFAULT 'Aktif'");
        DB::statement("ALTER TABLE jurusan MODIFY status VARCHAR(255) NOT NULL DEFAULT 'A'");
        DB::statement("ALTER TABLE kurikulum MODIFY status VARCHAR(255) NOT NULL DEFAULT 'A'");
        DB::statement("ALTER TABLE tahun_akademik MODIFY status VARCHAR(255) NOT NULL DEFAULT 'N'");

        DB::statement("ALTER TABLE akun_level1 MODIFY jenis_mutasi VARCHAR(6) NOT NULL DEFAULT 'Debet'");
        DB::statement("ALTER TABLE akun_level2 MODIFY jenis_mutasi VARCHAR(6) NOT NULL DEFAULT 'Debet'");
        DB::statement("ALTER TABLE akun_level3 MODIFY jenis_mutasi VARCHAR(6) NOT NULL DEFAULT 'Debet'");
        DB::statement("ALTER TABLE rekening MODIFY jenis_mutasi VARCHAR(6) NOT NULL DEFAULT 'Debet'");
    }
};
