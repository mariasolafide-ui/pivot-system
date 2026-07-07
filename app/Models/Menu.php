<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\Addon;        // ← tambah ini
use App\Models\VariantGroup;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'short_description',
        'price', 'image', 'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price'        => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Menu $menu) {
            if (empty($menu->slug)) {
                $menu->slug = Str::slug($menu->name);
            }
        });

        static::updating(function (Menu $menu) {
            if ($menu->isDirty('name')) {
                $menu->slug = Str::slug($menu->name);
            }
        });
    }

    // ── Relasi ──────────────────────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Grup varian yang dipilih untuk menu ini (many-to-many global).
     * Eager-load variants supaya langsung bisa dipakai di blade.
     */
    public function variantGroups()
    {
        return $this->belongsToMany(
            VariantGroup::class,
            'menu_variant_group',
            'menu_id',
            'variant_group_id'
        )->with('variants');
    }

    /**
     * Addon/topping yang dipilih untuk menu ini (many-to-many global).
     */
    public function addons()
    {
        return $this->belongsToMany(
            Addon::class,
            'addon_menu',
            'menu_id',
            'addon_id'
        );
    }

    // ── Accessor ────────────────────────────────────────────────────────

    public function getImageUrlAttribute(): string
    {
        if ($this->image && \Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('images/menu-placeholder.png');
    }
}