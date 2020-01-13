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
    return $router->app->version() . '' . env('APP_NAME');
});

$router->post('account', ['uses' => 'AccountsController@create']);
$router->get('account', ['uses' => 'AccountsController@list']);
$router->get('account/{id}', ['uses' => 'AccountsController@show']);
$router->put('account/{id}', ['uses' => 'AccountsController@update']);
$router->delete('account/{id}', ['uses' => 'AccountsController@delete']);

$router->post('fee', ['uses' => 'FeesController@create']);
$router->get('fee', ['uses' => 'FeesController@list']);
$router->get('fee/{id}', ['uses' => 'FeesController@show']);
$router->put('fee/{id}', ['uses' => 'FeesController@update']);
$router->delete('fee/{id}', ['uses' => 'FeesController@delete']);


$router->post('inOut', ['uses' => 'InOutController@create']);
$router->get('inOut', ['uses' => 'InOutController@list']);
$router->get('inOut/{id}', ['uses' => 'InOutController@show']);
$router->put('inOut/{id}', ['uses' => 'InOutController@update']);
$router->delete('inOut/{id}', ['uses' => 'InOutController@delete']);
