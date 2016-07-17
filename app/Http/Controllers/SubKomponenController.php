<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Http\Requests;
use App\SubKomponen;
use App\Datduk;

class SubKomponenController extends NodeController
{
    protected $model = 'App\SubKomponen';
    
    public function create(Request $request)
    {
        $replaced         = $request->all();
        $replaced['code'] = trim($replaced['code'], '_');
        
        $request->replace($replaced);
        
        $this->validate($request, [
            'name'       => 'required',
            'anggaran'   => 'required',
            'code'       => 'required|max:3|alpha',
            'parent'     => 'required|max:4',
            'unit_kerja' => 'required|max:4'
        ]);

        try {
            $parent     = $request->input("parent");
            $code       = $request->input("code");
            $name       = $request->input("name");
            $unit_kerja = $request->input("unit_kerja");
            $anggaran   = str_replace(',', '', $request->input("anggaran"));
            $collect    = SubKomponen::where([['code', $code], ['parent', $parent]]);

            if (!$collect->get()->isEmpty()) {
                throw new InvalidArgumentException("Kode sudah tersedia", 422);
            }

            $sub_komponen = new SubKomponen;

            $sub_komponen->code       = $code;
            $sub_komponen->name       = $name;
            $sub_komponen->unit_kerja = $unit_kerja;
            $sub_komponen->parent     = $parent;
            $sub_komponen->anggaran   = $anggaran;
            $sub_komponen->save();


            if (!$request->hasFile('datduks')) {
                return response()->json(["message" => "Data berhasil disimpan"]);
            }

            $files = $request->file('datduks');

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $file_type = $file->getMimeType();
                $hash      = sha1_file($file->path());

                $datduk    = new Datduk;
                
                $datduk->filename  = $file_name;
                $datduk->mime_type = $file_type;
                $datduk->hash      = $hash;
                $datduk->parent    = $sub_komponen->id;
                $datduk->save();

                $file->move(storage_path('app/datduks'), 'DATDUK_' . $datduk->id);
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

    public function update($id, Request $request)
    {
        $replaced         = $request->all();
        $replaced['code'] = trim($replaced['code'], '_');
        
        $request->replace($replaced);
        
        $sub_komponen = SubKomponen::findOrFail($id);

        $this->validate($request, [
            'name'       => 'required',
            'anggaran'   => 'required',
            'code'       => 'required|max:3|alpha',
            'unit_kerja' => 'required|max:4'
        ]);

        try {
            $parent     = $request->input("parent");
            $code       = $request->input("code");
            $name       = $request->input("name");
            $unit_kerja = $request->input("unit_kerja");
            $anggaran   = str_replace(',', '', $request->input("anggaran"));
            
            $collect  = SubKomponen::where([['code', $code], ['parent', $parent]]);

            if (!$collect->get()->isEmpty()) {
                if ($sub_komponen->code != $code || $sub_komponen->parent != $parent) {
                    throw new InvalidArgumentException("Kode sudah tersedia", 422);
                }
            }

            $sub_komponen->code       = $code;
            $sub_komponen->name       = $name;
            $sub_komponen->unit_kerja = $unit_kerja;
            $sub_komponen->parent     = $parent;
            $sub_komponen->anggaran   = $anggaran;
            $sub_komponen->save();


            if (!$request->hasFile('datduks')) {
                return response()->json(["message" => "Data berhasil disimpan"]);
            }

            $files = $request->file('datduks');

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $file_type = $file->getMimeType();
                $hash      = sha1_file($file->path());

                $datduk    = new Datduk;
                
                $datduk->filename  = $file_name;
                $datduk->mime_type = $file_type;
                $datduk->hash      = $hash;
                $datduk->parent    = $sub_komponen->id;
                $datduk->save();

                $file->move(storage_path('app/datduks'), 'DATDUK_' . $datduk->id);
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
