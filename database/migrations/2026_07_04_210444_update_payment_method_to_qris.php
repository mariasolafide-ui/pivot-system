<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Cek apakah kolom payment_method sudah ada
        $columns = DB::select("SHOW COLUMNS FROM orders LIKE 'payment_method'");
        
        if (!empty($columns)) {
            // Ubah ENUM dari ('cash','ewallet') menjadi ('cash','qris')
            DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cash', 'qris') NOT NULL DEFAULT 'cash'");
            
            // Update data yang masih 'ewallet' menjadi 'qris'
            DB::table('orders')
                ->where('payment_method', 'ewallet')
                ->update(['payment_method' => 'qris']);
        }
    }

    public function down()
    {
        // Rollback: kembalikan ke ENUM sebelumnya
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cash', 'ewallet') NOT NULL DEFAULT 'cash'");
    }
};