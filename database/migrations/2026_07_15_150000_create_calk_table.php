<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal');
            $table->longText('catatan')->nullable();
            $table->timestamps();
            $table->unique('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calk');
    }
};
