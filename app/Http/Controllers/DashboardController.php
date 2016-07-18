<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

use App\Kegiatan;
use App\Datduk;
use App\SubKomponen;
use App\EselonDua;
use App\EselonTiga;

use Auth;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class DashboardController extends Controller
{

    public function v0()
    {
        return response(var_dump(Auth::user()));
    }
    
    public function v1()
    {
        $datduks = collect(DB::table('datduks')
            ->join('sub_komponens', 'datduks.parent', '=', 'sub_komponens.id')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->select('datduks.*')->get());

        $sub_komponens = SubKomponen::all();        
        $eselon_dua    = EselonDua::orderBy('parent')->orderBy('codename')->get();

        $dataset   = [
            'units'         => $eselon_dua,
            'datduks'       => $datduks,
            'sub_komponens' => $sub_komponens,
            'parent'        => "Eselon I"
        ];
        
        return view("dashboard-v1", $dataset);
    }

    public function v2($eselon_dua)
    {
        $selected  = EselonDua::where('codename', $eselon_dua)->firstOrFail();

        $datduks = collect(DB::table('datduks')
            ->join('sub_komponens', 'datduks.parent', '=', 'sub_komponens.id')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->select('datduks.*')
                ->where([
                ['kegiatans.eselondua', $eselon_dua]
            ])->get());

        $sub_komponens = collect(DB::table('sub_komponens')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->select('sub_komponens.*')
                ->where([
                ['kegiatans.eselondua', $eselon_dua]
            ])->get());       

        $eselon_tiga   = EselonTiga::where('parent', $eselon_dua)
            ->orderBy('codename')->get();
        $dataset   = [
            'units'         => $eselon_tiga,
            'datduks'       => $datduks,
            'sub_komponens' => $sub_komponens,
            'parent'        => "Eselon II",
            'link'          => false,
            'selected'      => $selected
        ];
        
        return view("dashboard-v1", $dataset);
    }
}
