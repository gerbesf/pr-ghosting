<?php

namespace App;

use App\Models\Profiles;

class Profile {

    protected $layout = [
        'last_update',
        'hash',
        'steam_level',
        'nickname',
        'date_created',
        'id_address',
        'steam_tags'
    ];

    public $line_content;


    public function __construct( $line_content )
    {
        $index = 0;
        $this->line_content = collect(explode("\t",$line_content));

        return $this->handle();
    }

    public function handle()
    {

        // Bind Line
        $bind = [];
        foreach($this->layout as $index=>$key){
            $bind[ $key ] = $this->line_content[ $index ];
        }

        // Avaliable Scope
        $scope = [
            'nickname' => $bind['nickname'],
            'hash' => $bind['hash'],
            'steam_level' => $bind['steam_level'],
            'steam_tags' => $bind['steam_tags'],
        ];

        // Get Index Profile
        $Profile = Profiles::firstOrCreate([
            'nickname' => $bind['nickname'],
            'hash' => $bind['hash'],
        ]);

        // Update Steam Level
        $Profile->steam_level = $bind['steam_level'];

        // Update Steam Tags
        if($bind['steam_tags']){
            $Profile->steam_tags = $this->getTags($bind['steam_tags']);
        }

        // Save
        $Profile->save();

        return $scope;

    }

    /**
     * Get Tags
     * Return array from steam tags
     *
     * @param $string
     * @return array
     */
    public function getTags( $string ){
        $string = str_replace('(','',$string);
        $string = str_replace("\r",'',$string);
        $string = strtolower($string);
        return array_filter(explode(')',$string));
    }

}
