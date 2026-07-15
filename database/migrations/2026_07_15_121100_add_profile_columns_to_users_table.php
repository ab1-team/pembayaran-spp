<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 32)->nullable()->after('nama');
            $table->string('jabatan', 100)->nullable()->after('nik');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('jabatan');
            $table->string('telepon', 30)->nullable()->after('jenis_kelamin');
            $table->text('alamat')->nullable()->after('telepon');
            $table->string('foto')->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto', 'alamat', 'telepon', 'jenis_kelamin', 'jabatan', 'nik']);
        });
    }
};
