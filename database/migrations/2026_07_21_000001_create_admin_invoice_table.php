<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pembayaran');
            $table->date('tgl_invoice');
            $table->date('tgl_lunas')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->decimal('jumlah', 15, 2);
            $table->foreignId('user_id')->constrained('admin_user')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_invoice');
    }
};
