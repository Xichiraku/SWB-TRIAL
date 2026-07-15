<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class HistoryLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'history_logs';

    protected $fillable = [
        'bin_id',
        'bin_name',
        'homebase_id',
        'status',       // 'status', // Success | Full | Maintenance
        'message',
        'operator_id',  // siapa yang melakukan aksi (jika ada)
        'triggered_by', // 'system' | 'operator' | 'admin'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // -------------------------------------------------------
    // RELATIONS
    // -------------------------------------------------------

    public function bin()
    {
        return $this->belongsTo(Bin::class, 'bin_id', 'bin_id');
    }

    public function homebase()
    {
        return $this->belongsTo(Homebase::class, 'homebase_id', '_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id', '_id');
    }
}