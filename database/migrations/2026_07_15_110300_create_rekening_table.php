<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekening', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->default(0)->index();
            $table->unsignedTinyInteger('lev1')->default(0);
            $table->unsignedTinyInteger('lev2')->default(0);
            $table->unsignedTinyInteger('lev3')->default(0);
            $table->unsignedTinyInteger('lev4')->default(0);
            $table->string('kode_akun', 10);
            $table->string('nama_akun', 100);
            $table->enum('jenis_mutasi', ['debet', 'kredit'])->default('debet');
            $table->date('tgl_nonaktif')->nullable();
            $table->decimal('saldo', 15, 2)->default(0);
            $table->timestamps();
            $table->unique('kode_akun');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `rekening` MODIFY `jenis_mutasi` ENUM('debet','kredit') NOT NULL DEFAULT 'debet'");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rekening');
    }
};
