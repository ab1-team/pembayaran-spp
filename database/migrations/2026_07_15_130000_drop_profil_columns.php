<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil', function (Blueprint $table) {
            $table->dropColumn([
                'status_pembayaran',
                'toleransi_tunggakan',
                'pesan_tagihan',
                'pesan_pembayaran',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('profil', function (Blueprint $table) {
            $table->boolean('status_pembayaran')->default(0);
            $table->unsignedTinyInteger('toleransi_tunggakan')->default(0);
            $table->text('pesan_tagihan')->nullable();
            $table->text('pesan_pembayaran')->nullable();
        });
    }
};
