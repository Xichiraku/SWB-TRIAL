<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Peringatan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'peringatans';

    protected $fillable = [
        'homebase_id',
        'bin_code',     // ganti dari vacuum_code
        'type',         // 'capacity' | 'battery' | 'hardware' | 'offline'
        'title',
        'message',
        'priority',     // 'high' | 'medium' | 'low'
        'status',       // 'active' | 'resolved'
        'resolved_at',
        'resolved_by',  // _id user yang resolve
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // -------------------------------------------------------
    // RELATIONS
    // -------------------------------------------------------

    public function homebase()
    {
        return $this->belongsTo(Homebase::class, 'homebase_id', '_id');
    }

    public function bin()
    {
        return $this->belongsTo(Bin::class, 'bin_code', 'bin_id');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by', '_id');
    }

    // -------------------------------------------------------
    // SCOPES
    // -------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    // -------------------------------------------------------
    // HELPERS
    // -------------------------------------------------------

    public function resolve(string $userId): void
    {
        $this->status      = 'resolved';
        $this->resolved_at = now();
        $this->resolved_by = $userId;
        $this->save();
    }

    public function getBorderColorAttribute(): string
    {
        return match ($this->priority) {
            'high'   => 'border-red-500',
            'medium' => 'border-yellow-500',
            'low'    => 'border-blue-500',
            default  => 'border-gray-500',
        };
    }

    public function getBadgeColorAttribute(): string
    {
        return match ($this->priority) {
            'high'   => 'bg-red-100 text-red-700',
            'medium' => 'bg-yellow-100 text-yellow-700',
            'low'    => 'bg-blue-100 text-blue-700',
            default  => 'bg-gray-100 text-gray-700',
        };
    }
}