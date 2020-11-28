<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'id_clan',
        'id_steam',
        'nickname',
        'hash',
        'steam_level',
        'steam_tags',
        'status',
        'password',
    ];

    protected $casts = [
        'steam_tags'=>'array'
    ];

    public $timestamps = true;
}
