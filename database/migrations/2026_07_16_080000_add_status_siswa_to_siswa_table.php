<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('siswa', 'status_siswa')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->string('status_siswa')->after('status_awal');
            });
        }

        if (DB::getDriverName() === 'mysql' && Schema::hasColumn('siswa', 'status_siswa')) {
            DB::statement("ALTER TABLE `siswa` MODIFY `status_siswa` VARCHAR(255) NOT NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('siswa', 'status_siswa')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->dropColumn('status_siswa');
            });
        }
    }
};
