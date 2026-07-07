<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('retail_products', function (Blueprint $table) {
            // Menambahkan kolom weight bertipe integer setelah kolom name
            $table->integer('weight')->default(0)->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('retail_products', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
};