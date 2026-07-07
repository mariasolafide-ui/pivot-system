<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        // ──────────────────────────────────────────────────────────────────
        // 1. HAPUS TABEL LAMA (urutan harus benar karena foreign key)
        // ──────────────────────────────────────────────────────────────────
        Schema::dropIfExists('menu_variants');     // anak dari variant_groups
        Schema::dropIfExists('variant_groups');    // anak dari menus
        Schema::dropIfExists('menu_addons');       // anak dari menus
 
        // ──────────────────────────────────────────────────────────────────
        // 2. VARIANT GROUPS — sekarang GLOBAL, tidak terikat menu
        // ──────────────────────────────────────────────────────────────────
        Schema::create('variant_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // cth: "Ukuran", "Suhu", "Level Manis"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
 
        // ──────────────────────────────────────────────────────────────────
        // 3. MENU VARIANTS — tetap anak dari variant_groups (global)
        // ──────────────────────────────────────────────────────────────────
        Schema::create('menu_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')
                  ->constrained('variant_groups')
                  ->cascadeOnDelete();
            $table->string('name');               // cth: "Small", "Medium", "Large"
            $table->unsignedInteger('extra_price')->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
 
        // ──────────────────────────────────────────────────────────────────
        // 4. PIVOT: menu <-> variant_group (many-to-many)
        //    Satu menu bisa punya banyak grup, satu grup bisa dipakai banyak menu
        // ──────────────────────────────────────────────────────────────────
        Schema::create('menu_variant_group', function (Blueprint $table) {
            $table->foreignId('menu_id')
                  ->constrained('menus')
                  ->cascadeOnDelete();
            $table->foreignId('variant_group_id')
                  ->constrained('variant_groups')
                  ->cascadeOnDelete();
            $table->primary(['menu_id', 'variant_group_id']);
        });
 
        // ──────────────────────────────────────────────────────────────────
        // 5. ADDONS — sekarang GLOBAL, tidak terikat menu
        // ──────────────────────────────────────────────────────────────────
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // cth: "Extra Shot", "Coffee Jelly"
            $table->unsignedInteger('price')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
 
        // ──────────────────────────────────────────────────────────────────
        // 6. PIVOT: menu <-> addon (many-to-many)
        // ──────────────────────────────────────────────────────────────────
        Schema::create('addon_menu', function (Blueprint $table) {
            $table->foreignId('menu_id')
                  ->constrained('menus')
                  ->cascadeOnDelete();
            $table->foreignId('addon_id')
                  ->constrained('addons')
                  ->cascadeOnDelete();
            $table->primary(['menu_id', 'addon_id']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('addon_menu');
        Schema::dropIfExists('addons');
        Schema::dropIfExists('menu_variant_group');
        Schema::dropIfExists('menu_variants');
        Schema::dropIfExists('variant_groups');
    }
};
