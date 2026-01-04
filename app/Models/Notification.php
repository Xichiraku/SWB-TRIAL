<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notifications';
    
    protected $fillable = [
        'title',
        'message',
        'type',
        'source',
        'is_new',
        'has_check',
        'vacuum_code',
        'homebase_id'
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'has_check' => 'boolean',
    ];

    /**
     * Relasi ke homebase
     */
    public function homebase()
    {
        return $this->belongsTo(Homebase::class, 'homebase_id', '_id');
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->is_new = false;
        $this->save();
    }
}