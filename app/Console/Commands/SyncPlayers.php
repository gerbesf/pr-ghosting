<?php

namespace App\Console\Commands;

use App\Jobs\CdHashLine;
use App\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;

class SyncPlayers extends Command
{

    protected $signature = 'sync:players';

    protected $description = 'Sync all Players from PR-HASH';

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

        $response = Cache::remember('qserver',10000,function (){
            return Curl::to( env('PRG_HASH') )
                ->withAuthorization('Basic '.base64_encode(env('PRG_HTTP_USER').':'.env('PRG_HTTP_PASSWORD')))
                ->get();
        });

        foreach(explode("\n",$response) as $line){
            if(strlen($line)>=10){
                $result = new Profile( $line );
                echo '.';
            }
        }

    }
}
