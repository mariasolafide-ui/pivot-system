<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = ['name', 'price', 'is_available'];

    protected function casts(): array
    {
        return [
            'price'        => 'integer',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Menu-menu yang menggunakan addon ini.
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'addon_menu', 'addon_id', 'menu_id');
    }
}
