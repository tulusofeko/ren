<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Exception, InvalidArgumentException;
use Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Program;

class ProgramController extends Controller
{
    public function show($kode = null)
    {
        if (empty($kode)) {
            return view("program-manage");
        }

        return response()->json(Program::where('code', $kode)->firstOrFail());
    }

    public function create(Request $request)
    {
        try {
            $code      = $request->input("code");
            $name      = $request->input("name");
            
            if(empty($name) || empty($code)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }
            $program            = new Program;
            $program->name      = $name;
            $program->code      = $code;
            $program->save();

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

    public function Update(Program $program, Request $request)
    {
        try {
            $code      = $request->input("code");
            $name      = $request->input("name");
            
            if(empty($name) || empty($code)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }
            $program->name      = $name;
            $program->code      = $code;
            $program->save();

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

    public function delete(Program $program) 
    {
        try {
            $program->delete();

            return response()->json([
                "message" => "Data berhasil dihapus"
            ], 200);
            
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
            "error"   => $error, 
            "message" => $message,
            "raw"     => $msg_raw
        ], 500);
    }

    public function data()
    {
        return Datatables::of(Program::all())->make(true);
    }
}
