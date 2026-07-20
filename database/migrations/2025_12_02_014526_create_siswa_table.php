<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik', 16);
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nipd');
            $table->string('nisn');
            $table->string('no_kk', 16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('password');
            $table->string('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('dusun');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kode_pos');
            $table->string('kebutuhan_khusus');
            $table->enum('jenis_tinggal', ['orang_tua', 'asrama', 'kost', 'wali'])->default('orang_tua');
            $table->string('alat_transportasi');
            $table->string('hp');
            $table->string('email');
            $table->string('skhun');
            $table->string('penerima_kps');
            $table->string('no_kps');
            $table->string('foto')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->string('tahun_akademik');
            $table->enum('status_awal', ['baru', 'pindahan'])->default('baru');
            $table->string('kode_kelas');
            $table->string('ruang');
            $table->string('nama_ayah');
            $table->string('tahun_lahir_ayah');
            $table->string('pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');
            $table->string('kebutuhan_khusus_ayah');
            $table->string('no_telepon_ayah');
            $table->string('nama_ibu');
            $table->string('tahun_lahir_ibu');
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');
            $table->string('kebutuhan_khusus_ibu');
            $table->string('no_telepon_ibu');
            $table->string('nama_wali');
            $table->string('tahun_lahir_wali');
            $table->string('pendidikan_wali');
            $table->string('pekerjaan_wali');
            $table->string('penghasilan_wali');
            $table->string('kebutuhan_khusus_wali');
            $table->string('no_telepon_wali');
            $table->string('id_user');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `siswa` COMMENT = ''");
        DB::statement("ALTER TABLE `siswa` MODIFY `jenis_kelamin` ENUM('L','P') NOT NULL COMMENT 'L/P'");
        DB::statement("ALTER TABLE `siswa` MODIFY `nipd` VARCHAR(255) NOT NULL COMMENT 'Bisa diisi NIS'");
        DB::statement("ALTER TABLE `siswa` MODIFY `kebutuhan_khusus` VARCHAR(255) NOT NULL COMMENT 'Ya/Tidak'");
        DB::statement("ALTER TABLE `siswa` MODIFY `status_awal` ENUM('baru','pindahan') NOT NULL DEFAULT 'baru' COMMENT 'Baru / Pindahan'");
        DB::statement("ALTER TABLE `siswa` MODIFY `kode_kelas` VARCHAR(255) NOT NULL COMMENT 'Diterima di kelas ...'");
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
