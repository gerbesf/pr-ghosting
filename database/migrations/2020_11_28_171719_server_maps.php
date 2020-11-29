<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServerMaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_maps', function (Blueprint $table) {
            $table->id();
            $table->string('mapname');
            $table->string('gametype');
            $table->string('mapsize');
            $table->integer('numplayers');
            $table->integer('maxplayers');
            $table->string('status')->default('inative');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('server_maps');
    }
}
