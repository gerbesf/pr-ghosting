<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', 'IndexController@indexPage');
$router->get('/session/{session_id}', 'IndexController@sessionPage');
$router->get('/crond', 'IndexController@crondExec');

# Show random Str do APP_KEY in .env
#$router->get('/key', function() {
#    return \Illuminate\Support\Str::random(32);
#});
