<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Peringatan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'peringatans';

    protected $fillable = [
        'tipe',
        'pesan',
        'waktu',
    ];
}