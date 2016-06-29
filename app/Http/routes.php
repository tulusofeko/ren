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
 * Routes
 * -----------------------------------------------------------------------------
 */
    
Route::get('/', function () {
    return view("dashboard-v1");
});
    
// Eselon Satu Controller Route
Route::group(['prefix' => 'unit/eselon-satu', 'as' => 'eselon_satu.'], function () {

    Route::get('/{codename?}', 'EselonSatuController@show')->name('show');
    
    Route::post('/create', 'EselonSatuController@create')->name('create');

    Route::put('/update/{eselon_satu}', 'EselonSatuController@update')->name('update');
    
    Route::delete('/hapus/{eselon_satu}', 'EselonSatuController@delete')->name('delete');
    
    Route::any('/datatbl', 'EselonSatuController@data')->name('datatables');

});

// Eselon Dua Controller Route
Route::group(['prefix' => 'unit/eselon-dua', 'as' => 'eselon_dua.'], function () {

    Route::get('/{codename?}', 'EselonDuaController@show')->name('show');

    Route::post('/create', 'EselonDuaController@create')->name('create');

    Route::put('/update/{id}', 'EselonDuaController@update')->name('update');
    
    Route::delete('/hapus/{eselon_dua}', 'EselonDuaController@delete')->name('delete');
    
    Route::any('/datatbl', 'EselonDuaController@data')->name('datatables');

});

// Eselon Tiga Controller Route
Route::group(['prefix' => 'unit/eselon-tiga', 'as' => 'eselon_tiga.'], function () {

    Route::get('/{codename?}', 'EselonTigaController@show')->name('show');

    Route::post('/create', 'EselonTigaController@create')->name('create');

    Route::put('/update/{id}', 'EselonTigaController@update')->name('update');
    
    Route::delete('/hapus/{eselon_tiga}', 'EselonTigaController@delete')->name('delete');
    
    Route::any('/datatbl', 'EselonTigaController@data')->name('datatables');

});

// Program Controller Route
Route::group(['prefix' => 'program', 'as' => 'program.'], function () {

    Route::get('/{kode?}', 'ProgramController@show')->name('show');

    Route::post('/create', 'ProgramController@create')->name('create');

    Route::put('/update/{program}', 'ProgramController@update')->name('update');
    
    Route::delete('/hapus/{program}', 'ProgramController@delete')->name('delete');
    
    Route::any('/datatbl', 'ProgramController@data')->name('datatables');
});

// Kegiatan Controller Route
Route::group(['prefix' => 'kegiatan', 'as' => 'kegiatan.'], function () {

    Route::get('/{kode?}', 'KegiatanController@show')->name('show')
        ->where('kode', '[0-9]+');

    Route::post('/create', 'KegiatanController@create')->name('create');

    Route::put('/update/{kegiatan}', 'KegiatanController@update')->name('update');
    
    Route::delete('/hapus/{kegiatan}', 'KegiatanController@delete')->name('delete');
    
    Route::any('/datatbl', 'KegiatanController@data')->name('datatables');
});

// RKT Controller
Route::group(['prefix' => 'rkt', 'as' => 'rkt.'], function () {
    
    Route::get('/', 'RktController@show')->name('show');

    Route::any('/data', 'RktController@getData')->name('getdata');
    Route::any('/dx', 'RktController@dx')->name('dx');
});

// Output Controller Route
Route::group(['prefix' => 'output', 'as' => 'output.'], function () {

    Route::get('/{kode?}', 'OutputController@show')->name('show');

    Route::post('/create', 'OutputController@create')->name('create');

    Route::put('/update/{id}', 'OutputController@update')->name('update');
    
    Route::delete('/hapus/{id}', 'OutputController@delete')->name('delete');
    
    Route::any('/datatbl', 'OutputController@data')->name('datatables');
});

// SubOutput Controller Route
Route::group(['prefix' => 'suboutput', 'as' => 'suboutput.'], function () {

    Route::get('/{kode?}', 'SubOutputController@show')->name('show');

    Route::post('/create', 'SubOutputController@create')->name('create');

    Route::put('/update/{id}', 'SubOutputController@update')->name('update');
    
    Route::delete('/hapus/{id}', 'SubOutputController@delete')->name('delete');
    
    Route::any('/datatbl', 'SubOutputController@data')->name('datatables');
});

// Komponen Controller Route
Route::group(['prefix' => 'komponen', 'as' => 'komponen.'], function () {

    Route::get('/{kode?}', 'KomponenController@show')->name('show');

    Route::post('/create', 'KomponenController@create')->name('create');

    Route::put('/update/{id}', 'KomponenController@update')->name('update');
    
    Route::delete('/hapus/{id}', 'KomponenController@delete')->name('delete');
    
    Route::any('/datatbl', 'KomponenController@data')->name('datatables');
});

// SubKomponen Controller Route
Route::group(['prefix' => 'subkomponen', 'as' => 'subkomponen.'], function () {

    Route::get('/{kode?}', 'SubKomponenController@show')->name('show');

    Route::post('/create', 'SubKomponenController@create')->name('create');

    Route::put('/update/{id}', 'SubKomponenController@update')->name('update');
    
    Route::delete('/hapus/{id}', 'SubKomponenController@delete')->name('delete');
    
    Route::any('/datatbl', 'SubKomponenController@data')->name('datatables');
});

// Data Dukung Controller Route
Route::group(['prefix' => 'datduk', 'as' => 'datduk.'], function () {

    Route::get('/{datduk}', 'DatdukController@get')->name('show');

    Route::get('/bysk/{mak}', 'DatdukController@getBySubKomponen')->name('get');
    
    Route::delete('/hapus/{datduk}', 'DatdukController@delete')->name('delete');
    
    // Route::any('/datatbl', 'DatdukController@data')->name('datatables');
});

// Aktivitas Controller Route
Route::group(['prefix' => 'aktivitas', 'as' => 'aktivitas.'], function () {
    
    Route::get('/{kode?}', 'AktivitasController@show')->name('show');

    Route::post('/create', 'AktivitasController@create')->name('create');

    Route::put('/update/{id}', 'AktivitasController@update')->name('update');
    
    Route::delete('/hapus/{id}', 'AktivitasController@delete')->name('delete');
    
    Route::any('/datatbl', 'AktivitasController@data')->name('datatables');
});
