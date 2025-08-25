// database/migrations/2025_08_19_053516_create_tabungan_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabungan', function (Blueprint $table) {
            $table->id('id_tabungan');
            $table->char('id_user', 16);
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->decimal('total_tabungan', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('riwayat_tabungan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tabungan');
            $table->char('id_user', 16);
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->enum('jenis_transaksi', ['menabung', 'menarik']);
            $table->decimal('jumlah', 15, 2);
            $table->dateTime('tanggal_transaksi');
            $table->timestamps();

            $table->foreign('id_tabungan')->references('id_tabungan')->on('tabungan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_tabungan');
        Schema::dropIfExists('tabungan');
    }
};