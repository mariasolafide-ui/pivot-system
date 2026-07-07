<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order',        // ← TAMBAHKAN
        'category_id',      // ← TAMBAHKAN
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_order' => 'decimal:2',  // ← TAMBAHKAN
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isValid(): bool
    {
        $now = Carbon::today();
        return $this->is_active && $this->valid_from <= $now && $this->valid_until >= $now;
    }

    public function calculateDiscount($subtotal): float
    {
        if (!$this->isValid()) {
            return 0;
        }

        if ($subtotal < $this->min_order) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            return $subtotal * ($this->discount_value / 100);
        }

        return min($this->discount_value, $subtotal);
    }

    public function isApplicable($subtotal, $categoryIdsInCart = []): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($subtotal < $this->min_order) {
            return false;
        }

        // Jika tidak ada kategori yang dipilih, berlaku untuk semua
        if ($this->category_id === null) {
            return true;
        }

        // Jika ada kategori, cek apakah ada di keranjang
        return in_array($this->category_id, $categoryIdsInCart);
    }
}