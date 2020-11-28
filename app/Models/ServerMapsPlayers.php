<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerMapsPlayers extends Model
{
    protected $table = 'server_maps_players';

    protected $fillable = [
        'id_session',
        'nickname',
        'nickname_md5',
        'team',
        'online',
        'changed',
    ];

    public $timestamps = true;

    public function profile(){
        return $this->hasOne('\App\Models\Profiles', 'nickname', 'nickname');
    }

}


/*
 *  $table->bigInteger('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->boolean('')->default(false);
 */
