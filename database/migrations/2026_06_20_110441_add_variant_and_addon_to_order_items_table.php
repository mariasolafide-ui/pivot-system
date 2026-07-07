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
    Schema::table('order_items', function (Blueprint $table) {
        if (!Schema::hasColumn('order_items', 'variant_id')) {
            $table->unsignedBigInteger('variant_id')->nullable()->after('menu_id');
        }
        if (!Schema::hasColumn('order_items', 'variant_name')) {
            $table->string('variant_name')->nullable()->after('variant_id');
        }
        if (!Schema::hasColumn('order_items', 'addon_ids')) {
            $table->json('addon_ids')->nullable()->after('variant_name');
        }
        if (!Schema::hasColumn('order_items', 'addon_names')) {
            $table->string('addon_names')->nullable()->after('addon_ids');
        }
    });
}

public function down()
{
    Schema::table('order_items', function (Blueprint $table) {
        $table->dropColumn(['variant_id', 'variant_name', 'addon_ids', 'addon_names']);
    });
}
};
