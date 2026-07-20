<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE `jurusan` MODIFY `status` VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE `kurikulum` MODIFY `status` VARCHAR(255) NULL");
        DB::statement("ALTER TABLE `tahun_akademik` MODIFY `status` VARCHAR(255) NOT NULL");

        foreach (['akun_level1', 'akun_level2', 'akun_level3', 'rekening'] as $t) {
            DB::statement("ALTER TABLE `{$t}` MODIFY `jenis_mutasi` VARCHAR(6) NOT NULL DEFAULT 'Debet'");
        }

        DB::statement("ALTER TABLE `siswa` MODIFY `status_siswa` ENUM('aktif','nonaktif','blokir') NOT NULL DEFAULT 'aktif'");
        DB::statement("ALTER TABLE `spp` MODIFY `tgl_lunas` DATE NULL");
        DB::statement("ALTER TABLE `transaksi` MODIFY `idtp` VARCHAR(255) NULL");

        if (Schema::hasIndex('spp', 'spp_kode_idx')) {
            Schema::table('spp', function (Blueprint $table) {
                $table->dropIndex('spp_kode_idx');
            });
        }
    }

    public function down(): void
    {
    }
};