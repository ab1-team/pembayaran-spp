<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_tahun');
            $table->string('keterangan');
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif');
            $table->timestamps();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `tahun_akademik` MODIFY `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'nonaktif'");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_akademik');
    }
};
