<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Menambahkan kolom notes setelah kolom subtotal
            $table->string('notes')->nullable()->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Menghapus kembali kolom notes jika di-rollback
            $table->dropColumn('notes');
        });
    }
};