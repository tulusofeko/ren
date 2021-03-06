<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Exception;
use InvalidArgumentException;
use Validator;
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
        
        $eselon_dua = DB::table('eselon_dua')->join('eselon_satu', 
            // where
            'eselon_dua.parent', '=', 'eselon_satu.codename')
            // select
            ->select(
                'eselon_dua.*', 
                'eselon_satu.name as eselonsatu_name',
                'eselon_satu.codename as eselonsatu_code')
            // order & get
            ->orderBy('eselonsatu_code')->get();

        $dataset = [
            'eselon_dua' => collect($eselon_dua)->groupBy('eselonsatu_name'),
            'programs'   => Program::all()->sortBy('code')
        ];

        return view("kegiatan-manage", $dataset);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'code'      => 'required|unique:kegiatans,code|max:4',
            'eselondua' => 'required|max:4'
        ]);

        try {
            $program   = $request->input("program");
            $code      = $request->input("code");
            $name      = $request->input("name");
            $eselondua = $request->input("eselondua");
            
            $kegiatan            = new Kegiatan;
            $kegiatan->name      = $name;
            $kegiatan->code      = $code;
            $kegiatan->parent    = $program;
            $kegiatan->eselondua = $eselondua;
            $kegiatan->save();

            return response()->json(["message" => "Data berhasil disimpan"]);
        } catch (Exception $e) {

            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }

    public function update(Kegiatan $kegiatan, Request $request)
    {
        $prev = $request->header('referer');

        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'code'      => 'required|max:4',
            'eselondua' => 'required|max:4'
        ]);

        $validator->sometimes('code', 'unique:kegiatans,code',
            function($input) use ($kegiatan) {
                return $input->code != $kegiatan->code;
            });

        if ($validator->fails()) {

            if ($request->ajax()) {
                return response()->json($validator->messages(), 422);
            } 
                
            return redirect($prev)->withErrors($validator)->withInput();
        }

        try {
            $program   = $request->input("program");
            $code      = $request->input("code");
            $name      = $request->input("name");
            $eselondua = $request->input("eselondua");
            
            $kegiatan->name      = $name;
            $kegiatan->code      = $code;
            $kegiatan->parent    = $program;
            $kegiatan->eselondua = $eselondua;
            $kegiatan->save();

            return response()->json(["message" => "Data berhasil disimpan"]);
        } catch (Exception $e) {

            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }

    public function delete(Kegiatan $kegiatan) 
    {
        try {
            $kegiatan->delete();

            return response()->json(["message" => "Data berhasil dihapus"]);
            
        }  catch (Exception $e) {

            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }

    public function data()
    {
        return Datatables::of(Kegiatan::all())->make(true);
    }
}
