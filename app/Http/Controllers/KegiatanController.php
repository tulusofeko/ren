<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception, InvalidArgumentException;
use DB, Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Kegiatan;
use App\Program;

class KegiatanController extends Controller
{
    public function show($kode = null)
    {
        if (!empty($kode)) {
            return response()->json(
                Kegiatan::where('code', $kode)->firstOrFail()
            );
        }
        
        $eselon_dua = DB::table('eselon_dua') 
            ->join('eselon_satu', 'eselon_dua.parent', '=', 'eselon_satu.codename')
            ->select('eselon_dua.*', 
                'eselon_satu.name as eselonsatu_name', 
                'eselon_satu.codename as eselonsatu_code')
            ->orderBy('eselonsatu_code')
            ->get();
        $eselon_dua = collect($eselon_dua)->groupBy('eselonsatu_name');

        $programs = Program::all()->sortBy('code');
        
        return view("kegiatan-manage", [
            'eselon_dua' => $eselon_dua,
            'programs'   => $programs
        ]);
    }

    public function create(Request $request)
    {
        try {
            $code      = $request->input("code");
            $name      = $request->input("name");
            $program   = $request->input("program");
            $eselondua = $request->input("eselondua");
            
            if(empty($name) || empty($code) || empty($eselondua)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }
            $kegiatan            = new Kegiatan;
            $kegiatan->name      = $name;
            $kegiatan->code      = $code;
            $kegiatan->program   = $program;
            $kegiatan->eselondua = $eselondua;
            $kegiatan->save();

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

    public function update(Kegiatan $kegiatan, Request $request)
    {
        try {
            $code      = $request->input("code");
            $name      = $request->input("name");
            $program   = $request->input("program");
            $eselondua = $request->input("eselondua");
            
            if(empty($name)      || 
               empty($code)      || 
               empty($eselondua) || 
               empty($program)
            ) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }
            
            $kegiatan->name      = $name;
            $kegiatan->code      = $code;
            $kegiatan->program   = $program;
            $kegiatan->eselondua = $eselondua;
            $kegiatan->save();

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

    public function delete(Kegiatan $kegiatan) 
    {
        try {
            $kegiatan->delete();

            return response()->json([
                "message" => "Data berhasil dihapus"
            ], 200);
            
        }  catch (QueryException $e) {
            $error   = $e->getCode();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
            $message = "Tidak dapat menghapus. Kegiatan tidak kosong";
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
        $data = Kegiatan::all();

        return Datatables::of($data)->make(true);
    }
}
