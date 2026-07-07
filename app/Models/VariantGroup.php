<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantGroup extends Model
{
    protected $fillable = ['name', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Opsi-opsi pilihan yang ada di dalam grup ini.
     * cth: grup "Ukuran" punya opsi Small, Medium, Large
     */
    public function variants()
    {
        return $this->hasMany(MenuVariant::class, 'group_id');
    }

    /**
     * Menu-menu yang menggunakan grup varian ini.
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_variant_group', 'variant_group_id', 'menu_id');
    }
}