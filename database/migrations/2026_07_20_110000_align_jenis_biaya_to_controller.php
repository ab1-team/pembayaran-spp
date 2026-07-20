<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('jenis_biaya', 'id_jp')) {
            Schema::table('jenis_biaya', function (Blueprint $table) {
                $table->unsignedBigInteger('id_jp')->default(0)->after('id');
            });
        }

        if (DB::getDriverName() === 'mysql' && Schema::hasColumn('jenis_biaya', 'id_jp')) {
            DB::statement('UPDATE `jenis_biaya` SET `id_jp` = 1 WHERE `id_jp` = 0 OR `id_jp` IS NULL');
            DB::statement('ALTER TABLE `jenis_biaya` MODIFY `id_jp` BIGINT UNSIGNED NOT NULL');
        }

        DB::statement('
            DELETE jb1 FROM `jenis_biaya` jb1
            JOIN `jenis_biaya` jb2
              ON jb2.id_jp = jb1.id_jp
             AND jb2.angkatan = jb1.angkatan
             AND jb2.id > jb1.id
        ');

        Schema::table('jenis_biaya', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_biaya', 'kode_akun')) {
                $table->dropColumn('kode_akun');
            }
        });

        $fkExists = collect(DB::select(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'jenis_biaya'
               AND COLUMN_NAME = 'id_jp' AND REFERENCED_TABLE_NAME IS NOT NULL"
        ))->isNotEmpty();

        if (!$fkExists) {
            Schema::table('jenis_biaya', function (Blueprint $table) {
                $table->foreign('id_jp')->references('id')->on('jenis_pembayaran')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('jenis_biaya', function (Blueprint $table) {
            $table->dropForeign(['id_jp']);
            if (!Schema::hasColumn('jenis_biaya', 'kode_akun')) {
                $table->string('kode_akun')->after('angkatan');
            }
            if (Schema::hasColumn('jenis_biaya', 'id_jp')) {
                $table->dropColumn('id_jp');
            }
        });
    }
};
