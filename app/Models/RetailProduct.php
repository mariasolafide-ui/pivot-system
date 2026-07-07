<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailProduct extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan
    protected $table = 'retail_products';

    // Menentukan kolom mana saja yang boleh diisi (mass assignable)
    protected $fillable = [
        'name',
        'slug',
        'weight',
        'description',
        'price',
        'stock',
        'image',
        'is_available',
    ];

    /**
     * Relasi ke tabel OrderItem
     * Satu produk retail bisa dibeli di banyak item pesanan
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'retail_product_id');
    }
}