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

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'codename'  => 'required|unique:eselon_dua,codename|max:4',
            'parent'    => 'required|max:4',
            'pegawai'   => 'required|numeric'
        ]);

        try {
            $name           = $request->input("name");
            $codename       = $request->input("codename");
            $parent         = $request->input("parent");
            $pegawai        = $request->input("pegawai");
            
            $unit           = new EselonDua;
            $unit->name     = $name;
            $unit->codename = $codename;
            $unit->parent   = $parent;
            $unit->pegawai  = $pegawai;
            $unit->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (Exception $e) {

            return response()->json(
                ["error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }
        
    }

    public function update($id, Request $request)
    {
        // Compatibility wit 5.6.21
        $unit = EselonDua::findOrFail($id);

        $prev = $request->header('referer');

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'codename' => 'required|max:4',
            'parent'   => 'required|max:4',
            'pegawai'  => 'required|numeric'
        ]);

        $validator->sometimes('codename', 'unique:eselon_dua,codename', 
            function($input) use ($unit) {
                return "$input->codename" != $unit->codename;
            });

        if ($validator->fails()) {

            if ($request->ajax()) {
                return response()->json($validator->messages(), 422);
            } 
                
            return redirect($prev)->withErrors($validator)->withInput();
        }

        try {
            $codename       = $request->input("codename");
            $name           = $request->input("name");
            $parent         = $request->input("parent");
            $pegawai        = $request->input("pegawai");
            
            $unit->name     = $name;
            $unit->codename = $codename;
            $unit->parent   = $parent;
            $unit->pegawai  = $pegawai;
            $unit->save();

            return response()->json(["message" => "Data berhasil disimpan"]);
        } catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }
        
    }
}