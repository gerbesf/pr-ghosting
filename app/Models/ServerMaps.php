<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerMaps extends Model
{
    protected $table = 'server_maps';

    protected $fillable = [
        'mapname',
        'gametype',
        'status',
    ];

    public $timestamps = true;
}
