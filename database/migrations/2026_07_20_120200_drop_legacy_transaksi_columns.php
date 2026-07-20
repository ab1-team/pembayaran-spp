<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi', 'invoice')) {
                $table->dropColumn('invoice');
            }
            if (Schema::hasColumn('transaksi', 'kode_spp')) {
                $table->dropColumn('kode_spp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice');
            $table->string('kode_spp', 225)->index();
        });
    }
};