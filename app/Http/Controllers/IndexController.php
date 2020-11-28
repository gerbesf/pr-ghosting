<?php

namespace App\Http\Controllers;

use App\Models\ServerMaps;
use App\Models\ServerMapsPlayers;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexPage(){

        $maps = ServerMaps::paginate(10);

        return view('index',[
            'maps'=>$maps
        ]);
    }

    public function sessionPage( $session_id ){

        $session = ServerMaps::where('id',$session_id)->firstOrFail();
        $players = ServerMapsPlayers::where('id_session',$session_id)->with('profile')->orderBy('changed','desc')->get();
        return view('details',[
            'session'=>$session,
            'playersd'=>collect($players)->groupBy('team'),
        ]);

    }
}
