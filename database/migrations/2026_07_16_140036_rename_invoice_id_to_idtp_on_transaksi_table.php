<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->renameColumn('invoice_id', 'idtp');
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('idtp')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->renameColumn('idtp', 'invoice_id');
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('invoice_id')->change();
        });
    }
};
