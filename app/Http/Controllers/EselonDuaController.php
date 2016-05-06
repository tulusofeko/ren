<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\EselonDua;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class EselonDuaController extends Controller 
{

    public function index()
    {
        return view("eselon-dua");
    }

    public function create(Request $request)
    {
        $eselon_dua = new EselonDua;
        $eselon_dua->name      = ucfirst($request->input('name'));
        $eselon_dua->codename  = strtoupper($request->input('codename'));

        if ($eselon_dua->save()) {
            return response()->json(["error" => 0]);
        } else {
            return response()->json(["error" => 1]);
        }
    }

    public function update($codename, Request $request)
    {
        $eselon_dua = EselonDua::firstOrNew(['codename' => $codename]);

        $eselon_dua->name      = ucfirst($request->input('name'));
        $eselon_dua->codename  = strtoupper($request->input('codename'));

        if ($eselon_dua->save()) {
            return response()->json(["error" => 0]);
        } else {
            return response()->json(["error" => 1]);
        }
    }

    public function delete(EselonDua $eselon_dua)
    {
        if ($eselon_dua->delete()) {
            return response()->json(["error" => 0]);
        } else {
            return response()->json(["error" => 1]);
        }
    }

    /**
     * Datatable Personil Controller
     * @return mixed
     */
    public function data()
    {
        $eselon_dua = EselonDua::all();

        return Datatables::of($eselon_dua)->make(true);
    }

}