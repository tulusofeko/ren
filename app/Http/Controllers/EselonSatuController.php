<?php

namespace App\Http\Controllers;

use Exception, InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\EselonSatu;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class EselonSatuController extends UnitKerjaController 
{
    protected $model = "App\EselonSatu";
    protected $table = "eselon_satu";

    /**
     * Eselon I data dashboard table and data management 
     */
    public function show($codename = null) 
    { 
        if (empty($codename)) return view("eselon-satu"); 

        return response()->json(
            EselonSatu::where('codename', $codename)->firstOrFail()
        );
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'codename'  => 'required|unique:eselon_satu|max:2',
        ]);

        try {
            $name     = $request->input("name");
            $codename = $request->input("codename");
            
            $eselon_satu           = new EselonSatu;
            $eselon_satu->name     = $name;
            $eselon_satu->codename = $codename;
            $eselon_satu->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (Exception $e) {

            $message = get_class($e) . ": " . $e->getMessage();

            return response()->json([
                "error" => $e->getCode(), "message" => $message 
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        $eselon_satu  = EselonSatu::findOrFail($id);
        
        $validator   = Validator::make($request->all(), [
            'name'     => 'required',
            'codename' => 'required|max:2'
        ]);

        $validator->sometimes('codename', 'unique:eselon_satu,codename', 
            function($input) use ($eselon_satu) {
                return $input->codename != $eselon_satu->codename;
            });

        if ($validator->fails()) {

            if ($request->ajax()) {
                return response()->json($validator->messages(), 422);
            } else {
                $prev = $request->header('referer');

                return redirect($prev)->withErrors($validator)->withInput();
            }
        }
        
        try {
            $name        = $request->input("name");
            $codename    = $request->input("codename");

            $eselon_satu->name     = $name;
            $eselon_satu->codename = $codename;

            $eselon_satu->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (Exception $e) {

            $message = get_class($e) . ": " . $e->getMessage();

            return response()->json([
                "error" => $e->getCode(), "message" => $message 
            ], 500);
        }
    }
}