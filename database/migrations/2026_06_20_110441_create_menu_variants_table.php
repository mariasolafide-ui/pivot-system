<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menu_variants', function (Blueprint $table) {
            $table->id();
            // 1. DIUBAH: Hapus menu_id, ganti dengan group_id yang terhubung ke variant_groups
            $table->foreignId('group_id')->constrained('variant_groups')->onDelete('cascade');
            
            $table->string('name');                      // contoh: Hot, Ice, Large, Medium
            $table->integer('extra_price')->default(0);  // tambahan harga, 0 = sama
            $table->boolean('is_default')->default(false);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menu_variants');
    }
};