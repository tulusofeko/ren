<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\EselonSatu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Exception, InvalidArgumentException;

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
            $msg_raw = "";
            $message = "Penyimpanan berhasil";
        } catch (InvalidArgumentException $e) {
            $error   = $e->getCode();
            $message = $e->getMessage();
            $msg_raw = $message;
        } catch (Exception $e) {
            $error   = $e->getCode();
            $msg_raw = $e->getMessage();
            $message = "Terjadi kesalahan pada database";
        }
        
        return response()->json([
            "error"       => $error, 
            "message"     => $message,
            "message_raw" => $msg_raw
        ]);
    }

    public function update(EselonSatu $eselon_satu, Request $request)
    {

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
        $message_raw = "";
        try {
            $eselon_satu->delete();

            $error   = 0;
            $message = "Data berhasil dihapus";
        } catch (\Exception $e) {
            $error = $e->getCode();

            switch ($e->getCode()) {
                default:
                    $message = "Terjadi kesalahan";
                    break;
            }
            $message_raw = $e->getMessage();
        }
        
        return response()->json([
            "error"       => $error, 
            "message"     => $message,
            "message_raw" => $message_raw
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