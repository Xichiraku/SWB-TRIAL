<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Homebase extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'homebases';

    protected $fillable = [
        'nama',
        'lokasi',
        'status',
    ];
}