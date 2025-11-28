<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Vacuum extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vacuums';
    
    protected $fillable = [
        'code',
        'homebase_id',
        'status',
        'battery_level',
        'capacity',
        'last_maintenance'
    ];

    protected $casts = [
        'battery_level' => 'integer',
        'capacity' => 'integer',
        'last_maintenance' => 'datetime',
    ];

    public function homebase()
    {
        return $this->belongsTo(Homebase::class, 'homebase_id', '_id');
    }
}