<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_biaya', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_biaya', 'kode_akun')) {
                $table->dropColumn('kode_akun');
            }
        });

        Schema::table('jenis_biaya', function (Blueprint $table) {
            if (!Schema::hasColumn('jenis_biaya', 'id_jp')) {
                $table->unsignedBigInteger('id_jp')->after('id');
            }
        });

        if (Schema::hasColumn('jenis_biaya', 'id_jp') && DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `jenis_biaya` MODIFY `id_jp` BIGINT UNSIGNED NOT NULL');
        }

        Schema::table('jenis_biaya', function (Blueprint $table) {
            $table->foreign('id_jp')->references('id')->on('jenis_pembayaran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_biaya', function (Blueprint $table) {
            $table->dropForeign(['id_jp']);
            $table->dropColumn('id_jp');
            if (!Schema::hasColumn('jenis_biaya', 'kode_akun')) {
                $table->string('kode_akun')->after('id');
            }
        });
    }
};
