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
        Schema::create('users', function (Blueprint $table) {
            $table->char('id_user', 16)->primary();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'anggota']);
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('no_hp', 16);
            $table->date('tanggal_gabung');
            $table->string('foto')->nullable();
             $table->decimal('jasa', 20, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
