<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // 1. Mengubah menu_id lama menjadi nullable (boleh kosong)
            // Karena jika pelanggan beli kopi instan, kolom menu_id (kopi gelas) akan dikosongkan.
            $table->foreignId('menu_id')->nullable()->change();
            
            // 2. Menambahkan kolom baru untuk menampung ID Kopi Instan yang dibeli
            $table->foreignId('retail_product_id')
                  ->nullable()
                  ->after('menu_id')
                  ->constrained('retail_products')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['retail_product_id']);
            $table->dropColumn('retail_product_id');
            $table->foreignId('menu_id')->nullable(false)->change();
        });
    }
};