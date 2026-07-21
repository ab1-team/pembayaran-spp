<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_invoice')) {
            Schema::create('admin_invoice', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('jenis_pembayaran');
                $table->date('tgl_invoice');
                $table->date('tgl_lunas')->nullable();
                $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
                $table->decimal('jumlah', 15, 2);
                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                $table->index('user_id', 'admin_invoice_user_id_foreign');
                $table->foreign('user_id', 'admin_invoice_user_id_foreign')
                    ->references('id')->on('admin_user');
            });

            DB::statement('ALTER TABLE `admin_invoice` AUTO_INCREMENT = 3');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_invoice');
    }
};
