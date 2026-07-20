<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('kode_spp')->nullable()->after('spp_id');
        });

        DB::statement("
            UPDATE transaksi t
            JOIN spp s ON s.id = t.spp_id
            SET t.kode_spp = s.kode
            WHERE t.spp_id IS NOT NULL AND t.spp_id <> 0
        ");

        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('spp_id');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('spp_id')->nullable()->after('kode_spp');
        });

        DB::statement("
            UPDATE transaksi t
            JOIN spp s ON s.kode = t.kode_spp
            SET t.spp_id = s.id
            WHERE t.kode_spp IS NOT NULL AND t.kode_spp <> ''
        ");

        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('kode_spp');
        });
    }
};
