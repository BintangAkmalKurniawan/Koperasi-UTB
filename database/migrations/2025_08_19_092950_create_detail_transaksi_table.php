<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('no_transaksi');
            $table->unsignedBigInteger('id_product');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('saldo', 15, 2);
            $table->char('id_user');
            $table->timestamps();

            $table->foreign('no_transaksi')
                  ->references('no_transaksi')
                  ->on('transaksis')
                  ->onDelete('cascade');

            $table->foreign('id_product')
                  ->references('id_product')
                  ->on('products')
                  ->onDelete('cascade');

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('detail_transaksis');
    }
};