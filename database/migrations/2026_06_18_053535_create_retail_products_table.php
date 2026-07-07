<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retail_products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kopi instan / produk kopi
            $table->string('slug')->unique(); // Untuk URL ramah SEO (misal: kopi-instan-pivot)
            $table->text('description')->nullable(); // Penjelasan produk
            $table->integer('price'); // Harga produk
            $table->integer('stock')->default(0); // PENGUNCI STOK OTOMATIS
            $table->string('image')->nullable(); // Foto produk kopi instan
            $table->boolean('is_available')->default(true); // Status apakah aktif dijual atau tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retail_products');
    }
};