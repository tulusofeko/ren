<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use LogicException;
use DB;

use App\Http\Requests;
use App\Program;
use App\Kegiatan;
use App\Output;
use App\SubOutput;
use App\Komponen;
use App\Usulan;

class RktController extends Controller
{
    public function show()
    {
        $kegiatans = DB::table('kegiatans')->join('programs', 
            // where
            'kegiatans.parent', '=', 'programs.code')
            // select
            ->select(
                'kegiatans.*', 
                'programs.name as program_name',
                'programs.code as program_code')
            // order & get
            ->orderBy('program_code')->get();

        $dataset = [
            'kegiatans' => collect($kegiatans)->groupBy('program_name')->toArray()
        ];
        return view('rkt.manage', $dataset);
    }

    public function getData(Request $request)
    {
        $mak  = $request->input('id', '051.01');
        
        try {
            $data = $this->makResolve($mak);
        } catch (ModelNotFoundException $e) {
            abort(404);            
        } catch (LogicException $e) {
            $data = collect();            
        }
        
        $result = $data->sortBy('code')->values()->toArray();
            
        return response()->json($result);
    }

    protected function makResolve($mak)
    {
        $maks = explode('.', $mak);
        
        switch (sizeof($maks)) {
            case 2:
                return Program::all();
                break;
            case 3:
                $program = $maks[2];
                return Program::where('code', $program)->firstOrFail()->childs;
                break;
            case 4:
                $kegiatan = $maks[3];
                return Kegiatan::where('code', $kegiatan)->firstOrFail()->childs;
                break;
            case 5:
                $kegiatan = $maks[3];
                $output   = $maks[4];
                return Output::where([
                    ['code', $output], ['parent', $kegiatan]
                ])->firstOrFail()->childs;
                break;
            case 6:
                $kegiatan    = $maks[3];
                $output_code = $maks[4];
                $suboutput   = $maks[5];
                
                $output      = Output::where([
                    ['code', $output_code], ['parent', $kegiatan]
                ])->firstOrFail();

                return SubOutput::where([
                    ['code', $suboutput], ['parent', $output->id]
                ])->firstOrFail()->childs;
                break;
            case 7:
                $kegiatan       = $maks[3];
                $output_code    = $maks[4];
                $suboutput_code = $maks[5];
                $komponen_code  = $maks[6];

                $output         = Output::where([
                    ['code', $output_code], ['parent', $kegiatan]
                ])->firstOrFail();
                
                $suboutput      = SubOutput::where([
                    ['code', $suboutput_code], ['parent', $output->id]
                ])->firstOrFail();

                return Komponen::where([
                    ['code', $komponen_code], ['parent', $suboutput->id]
                ])->firstOrFail()->childs;
                break;
            default:
                abort(404);
        }
    }
}
