<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Vacuum extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vacuums';

    protected $fillable = [
        'id_homebase',
        'level',
        'kondisi',
    ];
}