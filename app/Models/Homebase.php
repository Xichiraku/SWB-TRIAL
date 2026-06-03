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
        'status',       // 'Active' | 'Inactive'
        'temperature',
        'power_status',
        // vacuum_assigned & active_vacuums dihapus —
        // dihitung live dari relasi bins()
    ];

    protected $casts = [
        'temperature' => 'float',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // -------------------------------------------------------
    // RELATIONS
    // -------------------------------------------------------

    public function bins()
    {
        return $this->hasMany(Bin::class, 'homebase_id', '_id');
    }

    // -------------------------------------------------------
    // ACCESSORS (live count, tidak disimpan ke DB)
    // -------------------------------------------------------

    public function getBinAssignedAttribute(): int
    {
        return $this->bins()->count();
    }

    public function getActiveBinsAttribute(): int
    {
        return $this->bins()->where('is_active', true)->count();
    }
}