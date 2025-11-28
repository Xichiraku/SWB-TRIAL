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

    public function vacuums()
    {
        return $this->hasMany(Vacuum::class, 'homebase_id', '_id');
    }

    public function peringatans()
    {
        return $this->hasMany(Peringatan::class, 'homebase_id', '_id');
    }
} 