<?php
// app/Models/Setting.php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Setting extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'settings';

    protected $fillable = [
        'notif_enabled',
        'capacity_alert',
        'battery_alert',
        'nurse_alert',
        'email_notif',
        'push_notif',
        'collection_threshold',
        'battery_threshold',
        'refresh_interval',
        'theme',
        'language',
        'units'
    ];

    protected $casts = [
        'notif_enabled' => 'boolean',
        'capacity_alert' => 'boolean',
        'battery_alert' => 'boolean',
        'nurse_alert' => 'boolean',
        'email_notif' => 'boolean',
        'push_notif' => 'boolean',
        'collection_threshold' => 'integer',
        'battery_threshold' => 'integer',
        'refresh_interval' => 'integer'
    ];
}