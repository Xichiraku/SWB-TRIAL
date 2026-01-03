<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bin extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    
    // Pastikan ini 'bins' (sesuai yang kamu konfirmasi)
    protected $collection = 'bins';

    // Field disesuaikan dengan screenshot database MongoDB kamu
    protected $fillable = [
        'code',             // PENTING: Di DB namanya 'code', bukan 'bin_id'
        'homebase_id',
        'status',           // Di DB isinya "active", "maintenance", dll
        'capacity',
        'battery_level',    // PENTING: Di DB namanya 'battery_level', bukan 'battery'
        'last_maintenance',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'battery_level' => 'integer', // Casting kolom yang benar
        'last_maintenance' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // --- SCOPES (Filter Query) ---

    // Scope Active: Mengecek apakah status di string adalah "active"
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope By Status: Mengubah filter dashboard (Full/Normal) menjadi query kapasitas
    public function scopeByStatus($query, $filter)
    {
        if ($filter === 'Full') {
            return $query->where('capacity', '>=', 85);
        }
        
        if ($filter === 'Normal') {
            return $query->where('capacity', '<', 85);
        }
        
        if ($filter === 'Maintenance') {
            return $query->where('status', 'maintenance');
        }

        return $query;
    }

    // --- ACCESSORS & HELPERS ---

    // Menentukan warna badge status
    public function getStatusColorAttribute()
    {
        if ($this->status === 'maintenance') {
            return 'orange';
        }
        
        if ($this->capacity >= 85) {
            return 'red';
        }
        
        return 'green';
    }

    // Logic untuk menentukan apakah bin butuh perhatian
    public function needsAttention()
    {
        // Perhatian jika penuh, baterai lemah, atau maintenance
        return $this->capacity >= 85 || 
               $this->battery_level <= 30 || 
               $this->status === 'maintenance';
    }
}