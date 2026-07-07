<?php
// app/Models/WaiterCall.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaiterCall extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'status'];

    public function table()
    {
        return $this->belongsTo(CafeTable::class, 'table_id');
    }

    // Scope untuk panggilan aktif
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending']);
    }

    // Scope untuk panggilan menunggu
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Label status
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => '⏳ Menunggu Konfirmasi',
            'done' => '✅ Selesai',
            default => 'Status Tidak Diketahui'
        };
    }

    // Progress bar
    public function getProgressAttribute()
    {
        return match($this->status) {
            'pending' => 30,
            'done' => 100,
            default => 0
        };
    }

    // Warna status
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'done' => 'success',
            default => 'secondary'
        };
    }
}