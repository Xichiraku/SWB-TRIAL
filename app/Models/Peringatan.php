<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Peringatan extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'peringatans';

    protected $fillable = [
        'tipe',
        'pesan',
        'waktu',
        'created_at',
        'updated_at',
    ];
}