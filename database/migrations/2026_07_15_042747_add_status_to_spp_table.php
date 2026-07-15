<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spp', function (Blueprint $table) {
            $table->enum('status', ['L', 'B'])->default('B')->after('nominal');
        });
    }

    public function down(): void
    {
        Schema::table('spp', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
