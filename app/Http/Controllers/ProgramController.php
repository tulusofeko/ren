<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception, InvalidArgumentException;
use DB, Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Program;

class ProgramController extends Controller
{
    public function show($kode = null)
    {
        if (empty($kode)) {
            return view("program-manage");
        }

        return response()->json(Program::where('code', $kode)->firstOrFail());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'code'  => 'required|unique:programs,code|max:2'
        ]);

        try {
            $code      = $request->input("code");
            $name      = $request->input("name");
            
            $program            = new Program;
            $program->name      = $name;
            $program->code      = $code;
            $program->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }        
    }

    public function Update(Program $program, Request $request)
    {
        $referer   = $request->header('referer');

        $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'code' => 'required|max:2',
        ]);

        $validator->sometimes('code', 'unique:programs,codename', 
            function($input) use ($unit) {
                return $input->code != $unit->code;
            });

        if ($validator->fails()) {

            if ($request->ajax()) {
                return response()->json($validator->messages(), 422);
            }
                
            return redirect($referer)->withErrors($validator)->withInput();
        }

        try {
            $code      = $request->input("code");
            $name      = $request->input("name");
            
            $program->name      = $name;
            $program->code      = $code;
            $program->save();

            return response()->json(["message" => "Data berhasil disimpan"]);
        } catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }     
    }

    public function delete(Program $program) 
    {
        try {
            $program->delete();

            return response()->json(["message" => "Data berhasil dihapus"]);
            
        }  catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }   
    }

    public function data()
    {
        return Datatables::of(Program::all())->make(true);
    }
}
