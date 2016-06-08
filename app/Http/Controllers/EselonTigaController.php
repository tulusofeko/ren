<?php

namespace App\Http\Controllers;

use App\EselonSatu;
use App\EselonDua;
use App\EselonTiga;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Database\QueryException;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class EselonTigaController extends UnitKerjaController 
{
    protected $model = "App\EselonTiga";
    protected $table = "eselon_tiga";

    /**
     * Eselon III data dashboard and management
     */
    public function show($codename = null)
    {
        if (!empty($codename)) {
            return response()->json(
                EselonTiga::where('codename', $codename)->firstOrFail()
            );
        }
         
        $eselon_dua = DB::table('eselon_dua') 
            ->join('eselon_satu', 'eselon_dua.parent', '=', 'eselon_satu.codename')
            ->select('eselon_dua.*', 'eselon_satu.name as eselonsatu_name')
            ->get();
        $eselon_dua = collect($eselon_dua)->groupBy('eselonsatu_name');
    
        return view("eselon-tiga", ['eselon_dua' => $eselon_dua]);

    }

    /**
     * Datatable Personil Controller Override Prent
     * @return mixed
     */
    public function data()
    {
        $data = DB::table('eselon_tiga')
            ->join('eselon_dua', 
                'eselon_tiga.parent', '=', 'eselon_dua.codename'
            )
            ->select('eselon_tiga.*', 'eselon_dua.parent as eselonsatu');

        return Datatables::of($data)->make(true);
    }

}