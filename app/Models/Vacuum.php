<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Vacuum extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vacuums';
    
    protected $fillable = [
        'code',
        'name',
        'homebase_id',
        'location',
        'capacity',
        'battery',
        'status',
        'is_active'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'battery' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke homebase
     */
    public function homebase()
    {
        return $this->belongsTo(Homebase::class, 'homebase_id', '_id');
    }

    /**
     * Check apakah vacuum perlu dikosongkan (capacity > 80%)
     */
    public function needsEmptying()
    {
        return $this->capacity >= 80;
    }

    /**
     * Check apakah battery rendah (< 50%)
     */
    public function lowBattery()
    {
        return $this->battery < 50;
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        if ($this->capacity >= 80) {
            return 'Penuh';
        } elseif ($this->capacity >= 50) {
            return 'Normal';
        } else {
            return 'Kosong';
        }
    }
}