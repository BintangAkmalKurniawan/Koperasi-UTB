<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product');
            $table->string('path');
            $table->timestamps();

            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
