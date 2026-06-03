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
        'type',         // 'system' | 'task' | 'alert'
        'source',       // 'admin' | 'system'
        'is_new',
        'has_check',
        'bin_code',     // ganti dari vacuum_code
        'homebase_id',
        // Task-based messaging
        'assigned_to',  // _id operator yang ditugaskan
        'task_status',  // 'pending' | 'in_progress' | 'done'
        'notes',        // catatan lapangan dari operator
    ];

    protected $casts = [
        'is_new'      => 'boolean',
        'has_check'   => 'boolean',
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

    public function assignedOperator()
    {
        return $this->belongsTo(User::class, 'assigned_to', '_id');
    }

    // -------------------------------------------------------
    // SCOPES
    // -------------------------------------------------------

    public function scopeUnread($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeTasks($query)
    {
        return $query->where('type', 'task');
    }

    public function scopeForOperator($query, string $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    // -------------------------------------------------------
    // HELPERS
    // -------------------------------------------------------

    public function markAsRead(): void
    {
        $this->is_new = false;
        $this->save();
    }

    public function markInProgress(): void
    {
        $this->task_status = 'in_progress';
        $this->save();
    }

    public function markDone(string $notes = ''): void
    {
        $this->task_status = 'done';
        $this->is_new      = false;

        if ($notes !== '') {
            $this->notes = $notes;
        }

        $this->save();
    }
}