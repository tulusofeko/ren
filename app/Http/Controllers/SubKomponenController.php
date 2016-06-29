<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Http\Requests;
use App\SubKomponen;
use App\Datduk;

class SubKomponenController extends NodeController
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'anggaran' => 'required',
            'code'     => 'required|max:3|alpha',
            'parent'   => 'required|max:4'
        ]);

        try {
            $parent   = $request->input("parent");
            $code     = $request->input("code");
            $name     = $request->input("name");
            $anggaran = $request->input("anggaran");
            $collect  = SubKomponen::where([['code', $code], ['parent', $parent]]);

            if (!$collect->get()->isEmpty()) {
                throw new InvalidArgumentException("Kode sudah tersedia", 422);
            }

            $sub_komponen = new SubKomponen;

            $sub_komponen->code     = $code;
            $sub_komponen->name     = $name;
            $sub_komponen->parent   = $parent;
            $sub_komponen->anggaran = $anggaran;
            // $sub_komponen->save();

            return response(
                var_dump(
                    $request->hasFile('datduks'),
                    $request->file('datduks'),
                    $request->all(),
                    $_FILES
                )
            );

            if ($request->hasFile('datduks')) {
                # code...
            }
            
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
