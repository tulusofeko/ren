<?php

namespace App\Http\Controllers;

use App\EselonSatu;
use App\EselonDua;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class EselonDuaController extends UnitKerjaController 
{
    protected $model = "App\EselonDua";
    protected $table = "eselon_dua";

    public function index()
    {
        $eselon_satu = EselonSatu::all()->sortBy('codename');
        
        return view("eselon-dua", ['eselon_satu' => $eselon_satu]);
    }
}