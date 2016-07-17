<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Aktivitas;

class AktivitasController extends NodeController
{
    protected $model = 'App\Aktivitas';

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'personil' => 'required|numeric',
            'durasi'   => 'required|numeric',
            'parent'   => 'required|max:4'
        ]);

        try {
            $name       = $request->input("name");
            $parent     = $request->input("parent");
            $personil   = $request->input("personil");
            $durasi     = $request->input("durasi");
            $durasi_sum = $personil * $durasi * 344;

            $aktivitas  = new Aktivitas;

            $aktivitas->parent     = $parent;
            $aktivitas->personil   = $personil;
            $aktivitas->durasi     = $durasi;
            $aktivitas->durasi_sum = $durasi_sum;
            $aktivitas->name       = $name;
            $aktivitas->save();

            return response()->json(["message" => "Data berhasil disimpan"]);
        } catch (InvalidArgumentException $e) {

            return response()->json(["message" => $e->getMessage()], 422);
        
        } catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }

    public function update($id, Request $request)
    {
        $aktivitas = Aktivitas::where('id', $id)->firstOrFail();
        
        $this->validate($request, [
            'name'     => 'required',
            'personil' => 'required|numeric',
            'durasi'   => 'required|numeric',
            'parent'   => 'required|max:4'
        ]);

        try {
            $name       = $request->input("name");
            $parent     = $request->input("parent");
            $personil   = $request->input("personil");
            $durasi     = $request->input("durasi");
            $durasi_sum = $personil * $durasi * 344;

            $aktivitas->parent     = $parent;
            $aktivitas->personil   = $personil;
            $aktivitas->durasi     = $durasi;
            $aktivitas->durasi_sum = $durasi_sum;
            $aktivitas->name       = $name;
            $aktivitas->save();

            return response()->json(["message" => "Data berhasil disimpan"]);
        } catch (InvalidArgumentException $e) {

            return response()->json(["message" => $e->getMessage()], 422);
        
        } catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }
}
