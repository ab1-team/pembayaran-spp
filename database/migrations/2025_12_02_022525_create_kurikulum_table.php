<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_kurikulum');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `kurikulum` MODIFY `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif'");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
