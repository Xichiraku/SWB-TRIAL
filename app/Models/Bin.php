<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bin extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'bins';

    protected $fillable = [
        'bin_id',
        'name',
        'location',
        'latitude',
        'longitude',
        'status',
        'capacity',
        'battery',
        'last_updated',
        'is_active',
        'homebase_id'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'battery' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
        'last_updated' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // --- SCOPES (Filter Query) ---

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $filter)
    {
        if ($filter === 'Full') {
            return $query->where('status', 'Full');
        }
        
        if ($filter === 'Normal') {
            return $query->where('status', 'Normal');
        }
        
        if ($filter === 'Maintenance') {
            return $query->where('status', 'Maintenance');
        }

        return $query;
    }

    // --- HELPERS ---

    public function getStatusColorAttribute()
    {
        if ($this->status === 'Maintenance') {
            return 'orange';
        }
        
        if ($this->status === 'Full' || $this->capacity >= 85) {
            return 'red';
        }
        
        return 'green';
    }

    public function needsAttention()
    {
        return $this->status === 'Full' || 
               $this->capacity >= 85 || 
               $this->battery <= 30;
    }

    public function isFull()
    {
        return $this->status === 'Full' || $this->capacity >= 85;
    }

    public function lowBattery()
    {
        return $this->battery < 30;
    }
}