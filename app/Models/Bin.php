<?php
// app/Models/Bin.php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Bin extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bins';

    protected $fillable = [
        'bin_id',
        'name',
        'location',
        'status',
        'capacity',
        'battery',
        'latitude',
        'longitude',
        'last_updated',
        'is_active'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'battery' => 'integer',
        'is_active' => 'boolean',
        'last_updated' => 'datetime'
    ];

    // Scope untuk filter status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk bin aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get status color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Full' => 'red',
            'Normal' => 'green',
            'Maintenance' => 'orange',
            default => 'gray'
        };
    }

    // Check if bin needs attention
    public function needsAttention()
    {
        return $this->status === 'Full' || 
               $this->capacity >= 85 || 
               $this->battery <= 30;
    }
}