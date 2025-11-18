<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Vacuum extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'vacuums';

    protected $fillable = [
        'id_homebase',
        'level',
        'kondisi',
        'created_at',
        'updated_at',
    ];
}