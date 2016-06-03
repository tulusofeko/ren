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

    Route::get('/unit/eselon-tiga', 'EselonTigaController@index')
        ->name('eselon_tiga');

    Route::get('/unit/eselon-tiga/{alias}', function ($alias) {
        return response()->json(
            App\EselonTiga::where('codename', '=', $alias)->firstOrFail()
        );
    });

    Route::get('/program', 'ProgramController@manage')
        ->name('program');

    Route::get('/program/{kode}', function ($kode) {
        return response()->json(
            App\Program::where('code', '=', $kode)->firstOrFail()
        );
    });

    Route::get('/kegiatan', 'KegiatanController@manage')
        ->name('kegiatan');

    Route::get('/kegiatan/{kode}', function ($kode) {
        return response()->json(
            App\Kegiatan::where('code', '=', $kode)->firstOrFail()
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
            '/update/{id}', 'EselonDuaController@update'
        )->name('update');
        
        Route::delete(
            '/hapus/{eselon_dua}', 'EselonDuaController@delete'
        )->name('delete');
        
        Route::any(
            '/datatbl', 'EselonDuaController@data'
        )->name('datatables');
    });

    Route::group(['prefix' => 'unit/eselon-tiga', 'as' => 'eselon_tiga.'], 
    function () {
        Route::post(
            '/create', 'EselonTigaController@create'
        )->name('create');

        Route::put(
            '/update/{id}', 'EselonTigaController@update'
        )->name('update');
        
        Route::delete(
            '/hapus/{eselon_tiga}', 'EselonTigaController@delete'
        )->name('delete');
        
        Route::any(
            '/datatbl', 'EselonTigaController@data'
        )->name('datatables');
    });

    Route::group(['prefix' => 'program', 'as' => 'program.'], function () {
        Route::post(
            '/create', 'ProgramController@create'
        )->name('create');

        Route::put(
            '/update/{program}', 'ProgramController@update'
        )->name('update');
        
        Route::delete(
            '/hapus/{program}', 'ProgramController@delete'
        )->name('delete');
        
        Route::any(
            '/datatbl', 'ProgramController@data'
        )->name('datatables');
    });

    Route::group(['prefix' => 'kegiatan', 'as' => 'kegiatan.'], function () {
        Route::post(
            '/create', 'KegiatanController@create'
        )->name('create');

        Route::put(
            '/update/{kegiatan}', 'KegiatanController@update'
        )->name('update');
        
        Route::delete(
            '/hapus/{kegiatan}', 'KegiatanController@delete'
        )->name('delete');
        
        Route::any(
            '/datatbl', 'KegiatanController@data'
        )->name('datatables');
    });
});