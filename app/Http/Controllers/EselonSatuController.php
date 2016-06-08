<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception, InvalidArgumentException;
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
        try {
            $name     = $request->input("name");
            $codename = $request->input("codename");
            
            if(empty($name) || empty($codename)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }

            $eselon_satu           = new EselonSatu;
            $eselon_satu->name     = $name;
            $eselon_satu->codename = $codename;
            $eselon_satu->save();

            return response()->json([
                "message" => "Data berhasil disimpan"
            ], 200);

        } catch (QueryException $e) {
            $error   = $e->getCode();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
            $message = "Terjadi kesalahan pada database";
        } catch (Exception $e) {
            $error   = $e->getCode();
            $message = $e->getMessage();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
        }
        
        return response()->json([
            "error"   => $error, 
            "message" => $message,
            "raw"     => $msg_raw
        ], 500);
    }

    public function update($id, Request $request)
    {
        $eselon_satu = EselonSatu::find($id);
        
        try {
            $name     = $request->input("name");
            $codename = $request->input("codename");
            
            if(empty($name) || empty($codename)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }

            $eselon_satu->name     = $name;
            $eselon_satu->codename = $codename;

            $eselon_satu->save();

            return response()->json([
                "message" => "Data berhasil disimpan"
            ], 200);

        } catch (QueryException $e) {
            $error   = $e->getCode();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
            $message = "Terjadi kesalahan pada database";
        } catch (Exception $e) {
            $error   = $e->getCode();
            $message = $e->getMessage();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
        }
        
        return response()->json([
            "error"   => $error, 
            "message" => $message,
            "raw"     => $msg_raw
        ], 500);
    }
}