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
        'status',               // 'Normal' | 'Full' | 'Maintenance'
        'organic_capacity',     // % tank organik (0-100)
        'anorganic_capacity',   // % tank anorganik (0-100)
        'battery',
        'is_active',
        'homebase_id',
        'last_emptied',
        // Hardware (dari ESP32)
        'esp32_status',         // 'Online' | 'Offline'
        'conveyor_status',      // 'Active' | 'Standby' | 'Error'
        'pir_status',           // 'Detecting' | 'Idle'
        'servo_status',         // 'Ready' | 'Error'
        // Sorting stats
        'organic_count',        // total item organik terpilah
        'anorganic_count',      // total item anorganik terpilah
        // Predictive analytics
        'full_prediction_minutes', // menit hingga prediksi penuh
    ];

    protected $casts = [
        'organic_capacity'         => 'integer',
        'anorganic_capacity'       => 'integer',
        'battery'                  => 'integer',
        'latitude'                 => 'float',
        'longitude'                => 'float',
        'is_active'                => 'boolean',
        'organic_count'            => 'integer',
        'anorganic_count'          => 'integer',
        'full_prediction_minutes'  => 'integer',
        'last_emptied'             => 'datetime',
        'created_at'               => 'datetime',
        'updated_at'               => 'datetime',
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

    public function peringatans()
    {
        return $this->hasMany(Peringatan::class, 'bin_code', 'bin_id');
    }

    // -------------------------------------------------------
    // SCOPES
    // -------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNeedsAttention($query)
    {
        return $query->where('status', '!=', 'Maintenance')
                     ->where(function ($q) {
                         $q->where('status', 'Full')
                           ->orWhere('organic_capacity', '>=', 85)
                           ->orWhere('anorganic_capacity', '>=', 85)
                           ->orWhere('battery', '<', 30);
                     });
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // -------------------------------------------------------
    // ACCESSORS & HELPERS
    // -------------------------------------------------------

    /**
     * Kapasitas tertinggi antara dua tank — dipakai untuk sorting & warning
     */
    public function getCapacityAttribute(): int
    {
        return max($this->organic_capacity ?? 0, $this->anorganic_capacity ?? 0);
    }

    public function isFull(): bool
    {
        return $this->status === 'Full'
            || ($this->organic_capacity ?? 0) >= 85
            || ($this->anorganic_capacity ?? 0) >= 85;
    }

    public function lowBattery(): bool
    {
        return ($this->battery ?? 100) < 30;
    }

    public function needsAttention(): bool
    {
        return $this->isFull() || $this->lowBattery() || $this->status === 'Maintenance';
    }

    public function isOnline(): bool
    {
        return $this->esp32_status === 'Online' && $this->is_active;
    }

    /**
     * Label prediksi untuk operator, contoh: "± 4j 20m"
     */
    public function getFullPredictionLabelAttribute(): string
    {
        $minutes = $this->full_prediction_minutes;

        if (!$minutes || $minutes <= 0) {
            return 'Tidak diketahui';
        }

        $hours = intdiv($minutes, 60);
        $mins  = $minutes % 60;

        return $hours > 0 ? "± {$hours}j {$mins}m" : "± {$mins}m";
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Full'        => 'red',
            'Maintenance' => 'orange',
            default       => 'green',
        };
    }
}