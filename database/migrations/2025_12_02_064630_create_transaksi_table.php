<?php

use App\Models\Transaksi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice');
            $table->date('tanggal_transaksi');
            $table->string('rekening_debit');
            $table->string('rekening_kredit');
            $table->string('kode_spp', 225);
            $table->integer('siswa_id');
            $table->integer('idtp');
            $table->string('keterangan');
            $table->string('jumlah');
            $table->string('urutan');
            $table->string('user_id');
            $table->timestamps();
            $table->index('kode_spp');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `transaksi` MODIFY `invoice` BIGINT(20) NOT NULL");
            DB::statement("ALTER TABLE `transaksi` MODIFY `idtp` INT(11) NOT NULL");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
