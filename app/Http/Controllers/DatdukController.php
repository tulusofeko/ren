<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SubKomponen;
use App\Datduk;
use DB;
use Storage;

class DatdukController extends Controller
{
    public function get(Datduk $datduk)
    {
        return response()->download(
            storage_path('app/datduks/DATDUK_' . $datduk->id),
            $datduk->filename
        );
    }

    public function getBySubKomponen($mak)
    {
        $maks = explode('.', $mak);

        if (sizeof($maks) < 8) {
            abort(404);
        }

        $kegiatan         = $maks[3];
        $output_code      = $maks[4];
        $suboutput_code   = $maks[5];
        $komponen_code    = $maks[6];
        $subkomponen_code = $maks[7];

        $sub_komponen = DB::table('sub_komponens')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->select('sub_komponens.*')
            ->where([
                ['outputs.parent', $kegiatan],
                ['outputs.code', $output_code],
                ['suboutputs.code', $suboutput_code],
                ['komponens.code', $komponen_code],
                ['sub_komponens.code', $subkomponen_code]
            ])->first();

        $datduks = Datduk::where('parent', $sub_komponen->id)->get();
        
        return response()->json($datduks->toArray());
    }

    public function delete(Datduk $datduk)
    {
        try {
            $datduk->delete();

            return response()->json(["message" => "Data berhasil dihapus"]);
            
        } catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }
}
