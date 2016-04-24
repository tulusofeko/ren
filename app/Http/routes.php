<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Symfony\Component\Yaml\Yaml;

Route::get('/', 'DashboardController@v1');

Route::get('/data/menu', ['as' => 'menu', function () {
    return response()->json(json_decode(
        file_get_contents(base_path() . '/resources/views/data/menu.json')
    ));
}]);