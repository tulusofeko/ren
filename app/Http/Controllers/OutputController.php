<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception, InvalidArgumentException;
use App\Http\Requests;
use App\Output;

class OutputController extends Controller
{
    public function show($kode = null) { }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'code'     => 'required|max:2',
            'kegiatan' => 'required|max:4'
        ]);

        try {
            $kegiatan  = $request->input("kegiatan");
            $code      = $request->input("code");
            $name      = $request->input("name");

            $collect = Output::where([['code', $code], ['kegiatan', $kegiatan]])->get();

            if (!$collect->isEmpty()) {
                throw new InvalidArgumentException(
                    "Kode sudah tersedia", 55
                );
            }

            $output         = new Output;
            $output->name   = $name;
            $output->parent = $kegiatan;
            $output->code   = $code;
            $output->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (InvalidArgumentException $e) {

            return response()->json(["code" => [$e->getMessage()]], 422);
        
        } catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }  
    }

    public function update(Output $output, Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'code'     => 'required|max:2',
            'kegiatan' => 'required|max:4'
        ]);

        try {
            $kegiatan  = $request->input("kegiatan");
            $code      = $request->input("code");
            $name      = $request->input("name");
            
            $collect = Output::where([['code', $code], ['parent', $kegiatan]])->get();

            if (!$collect->isEmpty() && $output->code !== $code) {
                throw new InvalidArgumentException(
                    "Kode sudah tersedia", 55
                );
            }

            $output->name      = $name;
            $output->parent    = $kegiatan;
            $output->code      = $code;
            $output->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (InvalidArgumentException $e) {

            return response()->json(["code" => [$e->getMessage()]], 422);
        
        } catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }

    public function delete(Output $output) 
    {
        try {
            $output->delete();

            return response()->json(["message" => "Data berhasil dihapus"]);
            
        }  catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }
}
