<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        
        $next = trim($request->input('next', ''), '.');

        try {
            $data = $this->makResolve($mak);
        } catch (Exception $e) {
            abort(404);            
        }
        
        if (empty($next)) {
            return response()
                ->json($data->sortBy('code')->values()->toArray());
        }
        
        foreach ($data as $item) {
            @list($current, $subload) = explode('.', $next, 2);
            if ($item->code == $current) {
                $item->setContinue();
                $item->setNextAttribute($subload);
            }
        }

        return response()
            ->json($data->sortBy('code')->values()->toArray());
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
                    ['code', $output], ['kegiatan', $kegiatan]
                ])->firstOrFail()->childs;
                break;
            default:
                abort(404);
        }
    }
}
