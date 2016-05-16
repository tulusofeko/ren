<?php

/*
|-------------------------------------------------------------------------------
| Application Routes
|-------------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Symfony\Component\Yaml\Yaml;

/**
 * -----------------------------------------------------------------------------
 * View
 * -----------------------------------------------------------------------------
 */
Route::group(['as' => 'view.'], function () {
    
    Route::get('/', 'DashboardController@v1');
    
    Route::get('/unit/eselon-satu', 'EselonSatuController@index')
        ->name('eselon_satu');
    
    Route::get('/unit/eselon-satu/{alias}', function ($alias) {
        return response()->json(
            App\EselonSatu::where('codename', '=', $alias)->firstOrFail()
        );
    });    
    
    Route::get('/unit/eselon-dua', 'EselonDuaController@index')
        ->name('eselon_dua');

    Route::get('/unit/eselon-dua/{alias}', function ($alias) {
        return response()->json(
            App\EselonDua::where('codename', '=', $alias)->firstOrFail()
        );
    });
});

/**
 * -----------------------------------------------------------------------------
 * API
 * -----------------------------------------------------------------------------
 */
Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::group(['prefix' => 'unit/eselon-satu', 'as' => 'eselon_satu.'], 
    function () {
        Route::post(
            '/create', 'EselonSatuController@create'
        )->name('create');

        Route::put(
            '/update/{eselon_satu}', 'EselonSatuController@update'
        )->name('update');
        
        Route::delete(
            '/hapus/{eselon_satu}', 'EselonSatuController@delete'
        )->name('delete');
        
        Route::any(
            '/datatbl', 'EselonSatuController@data'
        )->name('datatables');
    });

    Route::group(['prefix' => 'unit/eselon-dua', 'as' => 'eselon_dua.'], 
    function () {
        Route::post(
            '/create', 'EselonDuaController@create'
        )->name('create');

        Route::put(
            '/update/{codename}', 'EselonDuaController@update'
        )->name('update');
        
        Route::delete(
            '/hapus/{eselon_satu}', 'EselonDuaController@delete'
        )->name('delete');
        
        Route::any(
            '/datatbl', 'EselonDuaController@data'
        )->name('datatables');
    });
});