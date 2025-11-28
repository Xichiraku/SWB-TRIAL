<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Peringatan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'peringatans';
    
    protected $fillable = [
        'homebase_id',
        'vacuum_code',
        'type',
        'title',
        'message',
        'priority',
        'status'
    ];

    public function homebase()
    {
        return $this->belongsTo(Homebase::class, 'homebase_id', '_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getBorderColorAttribute()
    {
        return match($this->priority) {
            'high' => 'border-red-500',
            'medium' => 'border-yellow-500',
            'low' => 'border-blue-500',
            default => 'border-gray-500'
        };
    }
}