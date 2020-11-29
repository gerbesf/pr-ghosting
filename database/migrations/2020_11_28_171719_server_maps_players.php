<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServerMapsPlayers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_maps_players', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_session');
            $table->string('profile_index');
            $table->string('clan');
            $table->string('nickname');
            $table->string('team');
            $table->boolean('online')->nullable();
            $table->dateTime('online_time')->nullable();
            $table->boolean('changed')->nullable();
            $table->integer('changed_times')->default(0);
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
        Schema::drop('server_maps_players');
    }
}
