<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simpanan', function (Blueprint $table) {
            $table->id();
            $table->char('id_user', 16)->unique(); 
            $table->decimal('total_pokok', 15, 2)->default(0);
            $table->decimal('total_wajib', 15, 2)->default(0);
            $table->decimal('total_sukarela', 15, 2)->default(0);
            $table->date('wajib_terbayar_sampai')->nullable(); 
            $table->timestamps();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });

        Schema::create('riwayat_simpanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique(); 
            $table->char('id_user', 16);
            $table->enum('jenis_simpanan', ['pokok', 'wajib', 'sukarela']);
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_transaksi');
            $table->string('keterangan')->nullable(); 
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('simpanan', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
        Schema::table('riwayat_simpanans', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
        Schema::dropIfExists('simpanan');
    }
};