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
        Schema::create('shu_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shu_period_id')->constrained('shu_periods')->onDelete('cascade');
            $table->char('id_user', 16);
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->decimal('total_simpanan_anggota', 15, 2);
            $table->decimal('total_belanja_anggota', 15, 2)->default(0); // Asumsi ada data belanja
            $table->decimal('shu_jasa_modal', 15, 2);
            $table->decimal('shu_jasa_usaha', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shu_distribusi');
    }
};
