<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            $table->dropColumn('is_spp');
        });

        Schema::table('jenis_biaya', function (Blueprint $table) {
            $table->dropColumn('kode_akun');
        });

        Schema::table('jenis_biaya', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jp')->after('id');
            $table->foreign('id_jp')->references('id')->on('jenis_pembayaran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_biaya', function (Blueprint $table) {
            $table->dropForeign(['id_jp']);
            $table->dropColumn('id_jp');
        });

        Schema::table('jenis_biaya', function (Blueprint $table) {
            $table->string('kode_akun')->after('id');
        });

        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            $table->boolean('is_spp')->default(false)->after('kode_akun');
        });
    }
};
