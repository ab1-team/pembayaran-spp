<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('siswa', 'status_siswa')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->enum('status_siswa', ['aktif', 'nonaktif', 'blokir'])
                    ->default('aktif')
                    ->after('status_awal');
            });
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