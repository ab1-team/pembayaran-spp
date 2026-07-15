<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_laporans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_laporan', 100);
            $table->string('file', 100);
            $table->unsignedInteger('urut')->default(0);
            $table->unsignedBigInteger('id_lap')->default(0);
            $table->timestamps();

            $table->index('id_lap');
            $table->index(['file', 'id_lap']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_laporans');
    }
};
