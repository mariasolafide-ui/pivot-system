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
    Schema::table('menus', function (Blueprint $table) {
        $table->string('short_description', 150)->nullable()->after('description');
    });
}

public function down()
{
    Schema::table('menus', function (Blueprint $table) {
        $table->dropColumn('short_description');
    });
}
};
