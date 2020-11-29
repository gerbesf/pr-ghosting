<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerMapsPlayers extends Model
{
    protected $table = 'server_maps_players';

    protected $fillable = [
        'id_session',
        'profile_index',
        'clan',
        'nickname',
        'team',
        'online',
        'online_time',
        'changed',
        'changed_times',
    ];

    public $casts = [
        'changed'=>'boolean',
        'online_time'=>'datetime'
    ];

    public $timestamps = true;

    public function profile(){
        return $this->hasOne('\App\Models\Profiles', 'profile_index', 'profile_index');
    }

}


/*
 *  $table->bigInteger('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->boolean('')->default(false);
 */
