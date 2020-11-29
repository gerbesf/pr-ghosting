<?php

namespace App\Console\Commands;

use App\Jobs\CdHashLine;
use App\Models\ServerMaps;
use App\Models\ServerMapsPlayers;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;

class SyncServer extends Command
{

    protected $signature = 'sync:server';

    protected $description = 'Sync active players on server';

    // session map active
    public $date_session_created;
    public $id_session;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // PRSPY
        $data = Cache::remember('serverq',50,function (){
         return Curl::to( 'https://servers.realitymod.com/api/ServerInfo' )
             ->asJson()
             ->get();
        });

        // offline flag
        $offline = true;

        foreach(collect( $data->servers  )->toArray() as $block_server){

            if( $block_server->serverIp == env('REALITY_IP')){

                $offline = false;

                $this->readMapProperties($block_server->properties);

                $allPlayersNames = collect($block_server->players)->map(function ($obj){


                    $explode_nick = explode(' ',$obj->name);

                    if( count($explode_nick) ==2 ){
                        return $explode_nick[1];
                    }elseif(count($explode_nick) >= 3 ){
                        return implode(' ',$explode_nick);
                    }else{
                        return $obj->name;
                    }

                })->toArray();

                ServerMapsPlayers::where('id_session',$this->id_session)->whereNotIn('nickname',$allPlayersNames)->delete();
                /*ServerMapsPlayers::where('id_session',$this->id_session)->whereNotIn('nickname',$allPlayersNames)->update([
                    'online'=>false
                ]);*/

                foreach($block_server->players as $player){
                    $this->readAndUpdatePlayer($player);
                }


                #dd($block_server->players);
             #   dd($block_server->properties);
            }
        }

        // if is offline
        if($offline){

            $entity = ServerMaps::where('status','offline')->first();

            ServerMaps::where('status','running')->update([
                'status'=>'offline'
            ]);

            ServerMapsPlayers::where('id_session',$entity->id)->update([
                'online'=>false
            ]);

        }

    }

    public function readMapProperties( $properties ){
       # ServerMaps::where('')


        $getLatestMap = ServerMaps::orderBy('id','desc')->limit(1)->first();

        $scope = [
            'mapname'=>$properties->mapname,
            'gametype'=>$properties->gametype,
            'mapsize'=>$properties->bf2_mapsize,
            'numplayers'=>$properties->numplayers,
            'maxplayers'=>$properties->maxplayers,
        ];
        if($properties->numplayers>=1)
            $scope['status']='running';

        // Primeiro registro de mapa
        if(!$getLatestMap){
            $map = ServerMaps::create($scope);
            $this->id_session = $map->id;
            $this->date_session_created = $map->created_at;
        }else{

            if( $getLatestMap->mapname == $properties->mapname ){
                // Map is Running
                ServerMaps::where('id',$getLatestMap->id)->update($scope);

                $this->id_session = $getLatestMap->id;
                $this->date_session_created = $getLatestMap->created_at;

            }else{

                // Map has Change
                ServerMaps::where('status','running')->update([
                    'status'=>'terminated'
                ]);

                // Create new Index
                $map = ServerMaps::create($scope);

                $this->id_session = $map->id;
                $this->date_session_created = $map->created_at;
            }

        }

    }

    public function readAndUpdatePlayer($player){


        $explode_nick = explode(' ',$player->name);
      #  dd(count($explode_nick));

        $clan = null;
        $nickname = null;

        if( count($explode_nick) ==2 ){
            $clan = $explode_nick[0];
            $nickname = $explode_nick[1];
        }elseif(count($explode_nick) >= 3 ){
            $clan = $explode_nick[0];
            unset($explode_nick[0]);
            $nickname = implode(' ',$explode_nick);
        }else{
            $nickname = $player->name;
        }


        $scope = [
            'id_session'=>$this->id_session,
            'profile_index'=>md5($nickname),
            'clan'=>$clan,
            'nickname'=>$nickname,
            'team'=>$player->team,
            'online'=>true,
            'online_time'=>Carbon::now()
        ];

        $countEntity = ServerMapsPlayers::where('id_session',$this->id_session)->where('nickname',$scope['nickname'])->count();


        if($countEntity == 0 ){
            ServerMapsPlayers::create($scope);
        }else{
      #      ServerMapsPlayers::where('id_session',$this->id_session)->where('nickname',$scope['nickname'])->update($scope);
        }


        $activeEntity = ServerMapsPlayers::where('id_session',$this->id_session)->where('nickname',$scope['nickname'])->first();

        if( $activeEntity->team!=$player->team && Carbon::parse($activeEntity->created_at)->diffInMinutes()>=4){

            $update_scope['changed']=true;
            if(!$activeEntity->online){

            }


            ServerMapsPlayers::where('id_session',$this->id_session)->where('nickname',$scope['nickname'])->update($update_scope);
            ServerMapsPlayers::where('id_session',$this->id_session)->where('nickname',$scope['nickname'])->increment('changed_times');
        }

        echo Carbon::parse($activeEntity->created_at)->diffInSeconds().PHP_EOL;
/*
        if($ServerMapsPlayers->count() == 1  && Carbon::parse($activeEntity->date_created)->diffInMinutes() <= 3  ){
            ServerMapsPlayers::where('id_session',$this->id_session)->where('nickname',$scope['nickname'])->update($scope);
        }*/


        if($countEntity == 1 ){
            ServerMapsPlayers::where('id_session',$this->id_session)->where('nickname',$scope['nickname'])->update($scope);
        }



    }
}
