<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transaksi', 'spp_id')) {
            return;
        }

        DB::table('jenis_pembayaran')
            ->where('nama', 'Daftar Ulang')
            ->where('kode_akun', '1.1.03.01')
            ->update(['kode_akun' => '4.1.01.02', 'updated_at' => now()]);

        DB::table('rekening')
            ->where('kode_akun', '4.1.01.02')
            ->update(['nama_akun' => 'Daftar Ulang']);

        DB::table('transaksi')
            ->where('rekening_kredit', '1.1.03.01')
            ->where('spp_id', 0)
            ->update(['rekening_kredit' => '4.1.01.02', 'updated_at' => now()]);
    }

    public function down(): void
    {
        if (!Schema::hasColumn('transaksi', 'spp_id')) {
            return;
        }

        DB::table('transaksi')
            ->where('rekening_kredit', '4.1.01.02')
            ->where('spp_id', 0)
            ->update(['rekening_kredit' => '1.1.03.01', 'updated_at' => now()]);

        DB::table('rekening')
            ->where('kode_akun', '4.1.01.02')
            ->update(['nama_akun' => 'Pendapatan Abodemen']);

        DB::table('jenis_pembayaran')
            ->where('nama', 'Daftar Ulang')
            ->where('kode_akun', '4.1.01.02')
            ->update(['kode_akun' => '1.1.03.01', 'updated_at' => now()]);
    }
};
