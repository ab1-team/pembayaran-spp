<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'kode_jurusan')) {
                $table->string('kode_jurusan')->nullable()->after('kode_kelas');
            }
            if (!Schema::hasColumn('siswa', 'spp_nominal')) {
                $table->string('spp_nominal')->nullable()->after('ruang');
            }
            if (!Schema::hasColumn('siswa', 'tingkat')) {
                $table->string('tingkat')->nullable()->after('spp_nominal');
            }
        });

        Schema::table('transaksi', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi', 'spp_id')) {
                $table->integer('spp_id')->after('rekening_kredit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['kode_jurusan', 'spp_nominal', 'tingkat']);
        });
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('spp_id');
        });
    }
};