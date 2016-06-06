<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Program;
use App\Uraian;

class RktController extends Controller
{
    public function manage()
    {

        return view('rkt-manage');
    }

    public function get(Request $request)
    {
        $mak = $request->input('id', '051.01');

        if (strpos($mak, '051.01') === 0) {
            @list($program_code, $submak) = explode('.', substr($mak, 7));
        } else {
            return response()->json([]);
        }

        if (empty($program_code)) {
            return response()->json(Program::all()->toArray());
        } 

        $program = Program::where('code', $program_code)->first();
        
        if (!empty($program)) {
            return $this->makResolve($program, $submak);
        }

    }

    protected function makResolve(Uraian $komponen, $mak)
    {
        if (empty($mak)) {
            return response()->json($komponen->getChilds()->toArray());
        } 

        @list($subkomponen_id, $submak) = explode('.', $mak, 2);
        
        try {
            $subkomponen = $komponen->getChild($subkomponen_id);
            $this->makResolve($subkomponen, $submak);
        } catch (ModelNotFoundException $e) {
            return response()->json([]);
        }

    }
}
