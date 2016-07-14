<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use InvalidArgumentException;
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

    public function show($codename = null)
    {
        if (empty($codename)) {
            $eselon_satu = EselonSatu::all()->sortBy('codename');
            
            return view("eselon-dua", ['eselon_satu' => $eselon_satu]);
        }

        return response()->json(
            EselonDua::where('codename', $codename)->firstOrFail()
        );
    }
}