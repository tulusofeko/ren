<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;

use Exception, InvalidArgumentException;
use DB;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\UnitKerja;

class UnitKerjaController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'codename'  => 'required|unique:' . $this->table .',codename|max:4',
            'parent'    => 'required|max:4'
        ]);

        try {
            $name           = $request->input("name");
            $codename       = $request->input("codename");
            $parent         = $request->input("parent");
            
            $unit           = new $this->model;
            $unit->name     = $name;
            $unit->codename = $codename;
            $unit->parent   = $parent;
            $unit->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }
        
    }

    public function update($id, Request $request)
    {
        // Compatibility wit 5.6.21
        $unit = call_user_func($this->model ."::findOrFail", $id);

        $prev = $request->header('referer');

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'codename' => 'required|max:4',
            'parent'   => 'required|max:4'
        ]);

        $validator->sometimes('codename', 'unique:' . $this->table .',codename', 
            function($input) use ($unit) {
                return "$input->codename" != $unit->codename;
            });

        if ($validator->fails()) {

            if ($request->ajax()) {
                return response()->json($validator->messages(), 422);
            } 
                
            return redirect($prev)->withErrors($validator)->withInput();
        }

        try {
            $codename       = $request->input("codename");
            $name           = $request->input("name");
            $parent         = $request->input("parent");
            
            $unit->name     = $name;
            $unit->codename = $codename;
            $unit->parent   = $parent;
            $unit->save();

            return response()->json(["message" => "Data berhasil disimpan"]);
        } catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }
        
    }

    public function delete($id) 
    {
        try {
            $data = DB::table($this->table)->where('id', '=', $id);

            if ($data->count() === 0) { throw new Exception("Data not found"); }

            $data->delete();
            
            return response()->json(["message" => "Data berhasil dihapus"]);

        }  catch (Exception $e) {

            return response()->json([
                "error" => $e->getCode(), "message" => $e->getMessage()], 500
            );
        }
    }

    /**
     * Datatable UnitKerja Controller
     * @return mixed
     */
    public function data()
    {
        return Datatables::of(DB::table($this->table))->make(true);
    }
}
