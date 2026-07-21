<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_rekening')) {
            DB::statement("CREATE TABLE `admin_rekening` (
                `id` varchar(3) DEFAULT '0',
                `kd_rekening` varchar(10) NOT NULL DEFAULT '',
                `nama_rekening` varchar(50) DEFAULT '0',
                `pasangan` varchar(10) DEFAULT '0',
                PRIMARY KEY (`kd_rekening`) USING BTREE,
                KEY `kd_jb` (`id`,`nama_rekening`,`pasangan`) USING BTREE
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_rekening');
    }
};
