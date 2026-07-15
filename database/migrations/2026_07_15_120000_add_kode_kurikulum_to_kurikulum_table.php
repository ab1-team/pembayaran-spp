<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kurikulum', function (Blueprint $table) {
            $table->string('kode_kurikulum', 50)->nullable()->after('id');
            $table->unique('kode_kurikulum');
        });

        DB::statement("UPDATE kurikulum SET kode_kurikulum = CONCAT('K-', id) WHERE kode_kurikulum IS NULL");
    }

    public function down(): void
    {
        Schema::table('kurikulum', function (Blueprint $table) {
            $table->dropUnique(['kode_kurikulum']);
            $table->dropColumn('kode_kurikulum');
        });
    }
};
