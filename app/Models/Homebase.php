<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Homebase extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'homebases';
    
    protected $fillable = [
        'name',
        'location',
        'status',
        'vacuum_assigned',
        'active_vacuums',
        'temperature',
        'power_status'
    ];

    protected $casts = [
        'vacuum_assigned' => 'integer',
        'active_vacuums' => 'integer',
        'temperature' => 'float',
    ];

    /**
     * Get vacuums yang assigned ke homebase ini
     */
    public function vacuums()
    {
        return $this->hasMany(Vacuum::class, 'homebase_id', '_id');
    }

    /**
     * Get active vacuums count
     */
    public function getActiveAttribute()
    {
        return $this->vacuums()->where('is_active', true)->count();
    }
}