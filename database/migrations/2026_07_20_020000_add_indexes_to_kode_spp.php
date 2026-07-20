<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasIndex('spp', 'spp_kode_idx')) {
            Schema::table('spp', function (Blueprint $table) {
                $table->index('kode', 'spp_kode_idx');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasIndex('spp', 'spp_kode_idx')) {
            Schema::table('spp', function (Blueprint $table) {
                $table->dropIndex('spp_kode_idx');
            });
        }
    }
};
