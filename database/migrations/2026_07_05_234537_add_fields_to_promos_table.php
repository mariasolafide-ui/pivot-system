<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('promos', function (Blueprint $table) {
            // Minimal belanja
            $table->decimal('min_order', 15, 2)->default(0)->after('discount_value');
            
            // Kategori (nullable = berlaku untuk semua)
            $table->foreignId('category_id')->nullable()->after('min_order')->constrained('categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['min_order', 'category_id']);
        });
    }
};