<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_user')) {
            Schema::create('admin_user', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nama_lengkap');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('akses')->default('master');
                $table->timestamps();
            });

            DB::statement('ALTER TABLE `admin_user` AUTO_INCREMENT = 3');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_user');
    }
};
