<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spp', function (Blueprint $table) {
            $table->index('kode');
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->index('kode_spp');
        });
    }

    public function down(): void
    {
        Schema::table('spp', function (Blueprint $table) {
            $table->dropIndex(['kode']);
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropIndex(['kode_spp']);
        });
    }
};
