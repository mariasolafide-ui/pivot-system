<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuVariant extends Model
{
    protected $fillable = [
        'group_id', 'name', 'extra_price', 'is_default', 'is_available',
    ];

    protected function casts(): array
    {
        return [
            'extra_price'  => 'integer',
            'is_default'   => 'boolean',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Grup varian induk dari opsi ini.
     */
    public function group()
    {
        return $this->belongsTo(VariantGroup::class, 'group_id');
    }
}
