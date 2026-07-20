<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('spp', 'tgl_lunas')) {
            Schema::table('spp', function (Blueprint $table) {
                $table->date('tgl_lunas')->after('status');
            });
        }

        if (DB::getDriverName() === 'mysql' && Schema::hasColumn('spp', 'tgl_lunas')) {
            DB::statement("ALTER TABLE `spp` MODIFY `tgl_lunas` DATE NOT NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('spp', 'tgl_lunas')) {
            Schema::table('spp', function (Blueprint $table) {
                $table->dropColumn('tgl_lunas');
            });
        }
    }
};
