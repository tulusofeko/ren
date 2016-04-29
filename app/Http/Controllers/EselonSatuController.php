<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\EselonSatu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class EselonSatuController extends Controller 
{

    public function index()
    {
        return view("eselon-satu");
    }

    public function create(Request $request)
    {
        $eselon_satu = new EselonSatu;
        $eselon_satu->name      = ucfirst($request->input('name'));
        $eselon_satu->codename  = strtoupper($request->input('codename'));

        if ($eselon_satu->save()) {
            return response()->json(["error" => 0]);
        } else {
            return response()->json(["error" => 1]);
        }
    }

    public function update($codename, Request $request)
    {
        $eselon_satu = EselonSatu::firstOrNew(['codename' => $codename]);

        $eselon_satu->name      = ucfirst($request->input('name'));
        $eselon_satu->codename  = strtoupper($request->input('codename'));

        if ($eselon_satu->save()) {
            return response()->json(["error" => 0]);
        } else {
            return response()->json(["error" => 1]);
        }
    }

    public function delete(EselonSatu $eselon_satu)
    {
        if ($eselon_satu->delete()) {
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
        $eselon_satu = EselonSatu::all();

        return Datatables::of($eselon_satu)->make(true);
    }

}