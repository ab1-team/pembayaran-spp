<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun_level1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('lev1')->default(0);
            $table->unsignedTinyInteger('lev2')->default(0);
            $table->unsignedTinyInteger('lev3')->default(0);
            $table->unsignedTinyInteger('lev4')->default(0);
            $table->string('kode_akun', 10);
            $table->string('nama_akun', 100);
            $table->string('jenis_mutasi', 6)->default('Debet');
            $table->timestamps();
            $table->unique('kode_akun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun_level1');
    }
};
