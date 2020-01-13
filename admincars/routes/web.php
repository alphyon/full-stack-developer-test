<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version().''.env('APP_NAME');
});

$router->post('car',['uses'=>'CarsController@create']);
$router->get('car',['uses'=>'CarsController@list']);
$router->get('car/{id}',['uses'=>'CarsController@show']);
$router->put('car/{id}',['uses'=>'CarsController@update']);
$router->delete('car/{id}',['uses'=>'CarsController@delete']);

$router->post('park',['uses'=>'ParksController@create']);
$router->get('park',['uses'=>'ParksController@list']);
$router->get('park/{id}',['uses'=>'ParksController@show']);
$router->put('park/{id}',['uses'=>'ParksController@update']);
$router->delete('park/{id}',['uses'=>'ParksController@delete']);
