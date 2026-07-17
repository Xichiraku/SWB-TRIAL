<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bin extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'bins';

    // Berapa detik tanpa data baru dari ESP32 sebelum dianggap OFFLINE -> Maintenance
    const OFFLINE_THRESHOLD_SECONDS = 15;

    protected $fillable = [
        'bin_id',
        'name',
        'type',
        'device_id',
        'location',
        'latitude',
        'longitude',

        // HC-SR04
        'capacity',
        'tank_height_cm',
        'distance_cm',

        // YL-69
        'moisture',
        'moisture_percent',
        'moisture_status',
        'last_sort_result',

        // Sensor
        'sensor_error',
        'last_seen_at',

        'battery',
        'is_active',
        'homebase_id',
        'last_emptied',
        'full_logged',
        'task_status',
    ];

    protected $casts = [
        'capacity'       => 'integer',
        'tank_height_cm' => 'float',
        'distance_cm'    => 'float',

        // YL-69
        'moisture'           => 'integer',
        'moisture_percent'   => 'integer',
        'last_sort_result'   => 'string',

        'sensor_error'       => 'boolean',

        'battery'            => 'integer',

        'latitude'           => 'float',
        'longitude'          => 'float',

        'is_active'          => 'boolean',

        'last_emptied'       => 'datetime',
        'last_emptied'       => 'datetime',

        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'full_logged'        => 'boolean',
    ];  

    // -------------------------------------------------------
    // RELATIONS
    // -------------------------------------------------------

    public function homebase()
    {
        return $this->belongsTo(Homebase::class, 'homebase_id', '_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'bin_code', 'bin_id');
    }

    // -------------------------------------------------------
    // STATUS OTOMATIS (tidak disimpan manual, selalu dihitung ulang)
    // -------------------------------------------------------

    /**
     * Urutan prioritas:
     * 1. ESP32 offline (gak ada data masuk > threshold) -> Maintenance
     * 2. Sensor error (HC-SR04 timeout)                 -> Maintenance
     * 3. Kapasitas >= 85%                                -> Full
     * 4. Selain itu                                      -> Normal
     */
    public function getComputedStatusAttribute(): string
    {
        $lastSeen = $this->last_seen_at;
        if (is_numeric($lastSeen)) {
            $lastSeen = \Carbon\Carbon::createFromTimestampUTC((int) $lastSeen);
        } elseif ($lastSeen && is_string($lastSeen)) {
            $lastSeen = \Carbon\Carbon::parse($lastSeen);
        }

        if (!$this->last_seen_at || abs(now()->utc()->diffInSeconds($lastSeen, true)) > self::OFFLINE_THRESHOLD_SECONDS) {
            return 'Maintenance';
        }

        if ($this->sensor_error) {
            return 'Maintenance';
        }

        if (($this->capacity ?? 0) >= 90) {
            return 'Full';
        }

        if (($this->capacity ?? 0) >= 75) {
            return 'Warning';
        }

        return 'Normal';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->computed_status) {
            'Full'        => 'red',
            'Warning'     => 'yellow',
            'Maintenance' => 'orange',
            default       => 'green',
        };
    }

    public function isOnline(): bool
    {
        if (!$this->last_seen_at) {
            return false;
        }

        $lastSeen = $this->last_seen_at;
        if (is_numeric($lastSeen)) {
            $lastSeen = \Carbon\Carbon::createFromTimestampUTC((int) $lastSeen);
        } elseif (is_string($lastSeen)) {
            $lastSeen = \Carbon\Carbon::parse($lastSeen);
        }

        $secondsSinceLastSeen = abs(now()->utc()->diffInSeconds($lastSeen, true));

        return $secondsSinceLastSeen <= self::OFFLINE_THRESHOLD_SECONDS;
    }
}