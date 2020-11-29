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

        $maps = ServerMaps::orderBy('id','desc')->paginate(10);

        return view('index',[
            'maps'=>$maps
        ]);
    }

    public function sessionPage( $session_id ){

        $session = ServerMaps::where('id',$session_id)->firstOrFail();
        $players = ServerMapsPlayers::where('id_session',$session_id)
            // ->where('online',1)
            ->orderBy('changed','desc')->get();
        return view('details',[
            'session'=>$session,
            'playersd'=>collect($players)->groupBy('team'),
        ]);

    }

    public function trustPlayer( $session_id, $profile_index ){

        ServerMapsPlayers::where('id_session',$session_id)->where('profile_index',$profile_index)->update([
            'changed' => false,
            'changed_times' => 0,
        ]);

        return redirect('/session/'.$session_id);

    }
}
