<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception, InvalidArgumentException;
use App\Http\Requests;
use App\Output;

class OutputController extends Controller
{
    public function show($kode = null)
    {

    }

    public function create(Request $request)
    {
        try {
            $kegiatan  = $request->input("kegiatan");
            $code      = $request->input("code");
            $name      = $request->input("name");
            
            if(empty($name) || empty($code) || empty($kegiatan)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }


            $output            = new Output;
            $output->name      = $name;
            $output->kegiatan  = $kegiatan;
            $output->code      = $code;
            $output->save();

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

    public function update(Output $output, Request $request)
    {
        try {
            $kegiatan  = $request->input("kegiatan");
            $code      = $request->input("code");
            $name      = $request->input("name");
            
            if(empty($name) || empty($code) || empty($kegiatan)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }

            $output->name      = $name;
            $output->kegiatan  = $kegiatan;
            $output->code      = $code;
            $output->save();

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

    public function delete(Output $output) 
    {
        try {
            $output->delete();

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
}
