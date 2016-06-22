<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use LogicException;

use App\Http\Requests;
use App\Program;
use App\Kegiatan;
use App\Output;
use App\Usulan;

class RktController extends Controller
{
    public function show()
    {
        return view('rkt-manage');
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
            default:
                abort(404);
        }
    }
}
