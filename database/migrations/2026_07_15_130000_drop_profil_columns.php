<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $cols = ['status_pembayaran', 'toleransi_tunggakan', 'pesan_tagihan', 'pesan_pembayaran'];
        $existing = array_intersect($cols, \Illuminate\Support\Facades\Schema::getColumnListing('profil'));
        if ($existing) {
            Schema::table('profil', fn (Blueprint $t) => $t->dropColumn($existing));
        }
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
