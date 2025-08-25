<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shu_periods', function (Blueprint $table) {
            $table->id();
            $table->year('periode');
            $table->decimal('total_shu', 15, 2);
            $table->decimal('persen_jasa_modal', 5, 2);
            $table->decimal('persen_jasa_usaha', 5, 2);
            $table->decimal('total_simpanan_koperasi', 15, 2); 
            $table->decimal('total_penjualan_koperasi', 15, 2); 
            $table->enum('status', ['proses', 'dibagikan'])->default('proses');
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shu_periode');
    }
};
