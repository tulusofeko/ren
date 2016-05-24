<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\EselonSatu;
use App\EselonDua;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Exception, InvalidArgumentException;
use Illuminate\Database\QueryException;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class EselonDuaController extends Controller 
{

    public function index()
    {
        $eselon_satu = EselonSatu::all()->sortBy('codename');
        return view("eselon-dua", ['eselon_satu' => $eselon_satu]);
    }

    public function create(Request $request)
    {
        try {
            $name       = $request->input("name");
            $codename   = $request->input("codename");
            $eselonsatu = $request->input("eselon_satu");
            
            if(empty($name) || empty($codename) || empty($eselonsatu)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }
            $eselon_dua             = new EselonDua;
            $eselon_dua->name       = $name;
            $eselon_dua->codename   = $codename;
            $eselon_dua->eselonsatu = $eselonsatu;
            $eselon_dua->save();

            $error   = 0;
            $message = "Data berhasil disimpan"; 
            $msg_raw = $message;
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
        ]);
        
    }

    public function update(EselonDua $eselon_dua, Request $request)
    {
        try {
            $codename   = $request->input("codename");
            $name       = $request->input("name");
            $eselonsatu = $request->input("eselon_satu");
            
            if(empty($name) || empty($codename) || empty($eselonsatu)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }

            $eselon_dua->name       = $name;
            $eselon_dua->codename   = $codename;
            $eselon_dua->eselonsatu = $eselonsatu;
            $eselon_dua->save();

            $error   = 0;
            $message = "Data berhasil disimpan";
            $msg_raw = $message;
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
        ]);
    }

    public function delete(EselonDua $eselon_dua)
    {
        try {
            $eselon_dua->delete();

            $error   = 0;
            $message = "Data berhasil dihapus";
            $msg_raw = $message;
            
        }  catch (QueryException $e) {
            $error   = $e->getCode();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
            $message = "Terjadi kesalahan pada database";
        } catch (Exception $e) {
            $error   = $e->getCode();
            $message = $e->getMessage();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
        }
        
        return response()->json([
            "error"       => $error, 
            "message"     => $message,
            "message_raw" => $msg_raw
        ]);
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