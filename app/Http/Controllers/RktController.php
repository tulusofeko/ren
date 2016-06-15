<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Program;
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

        if (strpos($mak, '051.01') === 0) {
            @list($program_code, $submak) = explode('.', substr($mak, 7), 2);
        } else {
            abort(404);
        }

        if (empty($program_code)) {
            return response()->json(Program::all()->toArray());
        } 

        $program = Program::where('code', $program_code)->first();

        if (empty($program)) {
            abort(404);
        }

        $data = $this->makResolve($program, $submak);
        
        if (empty($next)) {
            return response($data->toArray());
        }

        foreach ($data as $item) {
            @list($current, $subload) = explode('.', $next, 2);
            if ($item->code == $current) {
                $item->setContinue();
                $item->setNextLoad($subload);
            }
            // var_dump($item, $next);
        }

        return response($data->toArray());
    }

    protected function makResolve(Usulan $komponen, $mak)
    {
        if (empty($mak)) {
            return $komponen->getChilds();
        } 

        @list($subkomponen_id, $submak) = explode('.', $mak, 2);
        
        try {
            $subkomponen = $komponen->getChild($subkomponen_id);
            return $this->makResolve($subkomponen, $submak);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

    }
}
