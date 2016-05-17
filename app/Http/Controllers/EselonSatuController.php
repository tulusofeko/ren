<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\EselonSatu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Exception, InvalidArgumentException;
use Illuminate\Database\QueryException;

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
        
        try {
            $name     = $request->input("name");
            $codename = $request->input("codename");
            
            if(empty($name) || empty($codename)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }

            $eselon_satu           = new EselonSatu;
            $eselon_satu->name     = ucfirst($request->input('name'));
            $eselon_satu->codename = strtoupper($request->input('codename'));
            $eselon_satu->save();

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

    public function update(EselonSatu $eselon_satu, Request $request)
    {
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

    public function delete(EselonSatu $eselon_satu)
    {
        try {
            $eselon_satu->delete();

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
        $eselon_satu = EselonSatu::all();

        return Datatables::of($eselon_satu)->make(true);
    }

}