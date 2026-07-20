<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanda_tangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tanda_tangan');
            $table->timestamps();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `tanda_tangan` MODIFY `tanda_tangan` TEXT NOT NULL");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tanda_tangan');
    }
};
