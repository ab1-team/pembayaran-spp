<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saldo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_akun', 10);
            $table->unsignedTinyInteger('bulan');
            $table->unsignedSmallInteger('tahun');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('kode_akun')->references('kode_akun')->on('rekening')->onDelete('cascade');
            $table->unique(['kode_akun', 'bulan', 'tahun']);
            $table->index(['tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo');
    }
};
