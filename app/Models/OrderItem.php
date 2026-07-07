<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 
        'menu_id', 
        'retail_product_id',
        'variant_id',
        'variant_name',
        'addon_ids',
        'addon_names',
        'quantity', 
        'unit_price', 
        'subtotal', 
        'notes'
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'subtotal'   => 'decimal:2',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function retailProduct()
    {
        return $this->belongsTo(RetailProduct::class, 'retail_product_id');
    }
}