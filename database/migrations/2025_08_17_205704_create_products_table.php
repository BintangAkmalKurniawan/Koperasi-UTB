<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product')->primary();
            $table->string('name'); 
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);            
            $table->integer('stock'); 
            $table->enum('category', ['pertanian', 'sarana', 'UMKM']);
            $table->unsignedBigInteger('thumbnail_id')->nullable(); 
            $table->string('id_user');
            $table->timestamps(); 
            $table->softDeletes('deleted_at'); 

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
        Schema::dropIfExists('products');
    }
};