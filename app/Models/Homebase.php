<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Homebase extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'homebases';

    protected $fillable = [
        'nama',
        'lokasi',
        'status',
        'created_at',
        'updated_at',
    ];
}