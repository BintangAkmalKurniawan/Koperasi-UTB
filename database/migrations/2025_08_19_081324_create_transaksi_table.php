<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaksis', function (Blueprint $table) {

            $table->id('no_transaksi')->primary();
            $table->char('id_user', 16);
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaksis');
    }
};