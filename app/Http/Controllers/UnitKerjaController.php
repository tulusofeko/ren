<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\UnitKerja;
use DB;
use Yajra\Datatables\Datatables;

class UnitKerjaController extends Controller
{
    public function create(Request $request)
    {
        try {
            $name     = $request->input("name");
            $codename = $request->input("codename");
            $parent   = $request->input("parent");
            
            if(empty($name) || empty($codename) || empty($parent)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }
            $unit           = new $this->model;
            $unit->name     = $name;
            $unit->codename = $codename;
            $unit->parent   = $parent;
            $unit->save();

            $error   = 0;
            $message = "Data berhasil disimpan"; 
            $msg_raw = $message;
        } catch (QueryException $e) {
            $error   = $e->getCode();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
            $message = "Terjadi kesalahan pada database";
        } catch (Exception $e) {
            $error   = $e->getCode();
            $message = $e->getMessage();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
        }
        
        return response()->json([
            "error"   => $error, 
            "message" => $message,
            "raw"     => $msg_raw
        ]);
        
    }

    public function update($id, Request $request)
    {
        $unit = $this->model::find($id);
        
        try {
            $codename = $request->input("codename");
            $name     = $request->input("name");
            $parent   = $request->input("parent");
            
            if(empty($name) || empty($codename) || empty($parent)) {
                throw new InvalidArgumentException(
                    "Data yang dimasukkan kosong", 44
                );
            }

            $unit->name     = $name;
            $unit->codename = $codename;
            $unit->parent   = $parent;
            $unit->save();

            $error   = 0;
            $message = "Data berhasil disimpan";
            $msg_raw = $message;
        } catch (QueryException $e) {
            $error   = $e->getCode();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
            $message = "Terjadi kesalahan pada database";
        } catch (Exception $e) {
            $error   = $e->getCode();
            $message = $e->getMessage();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
        }
        
        return response()->json([
            "error"   => $error, 
            "message" => $message,
            "raw"     => $msg_raw
        ]);
    }

    public function delete($id) 
    {
        try {
            DB::table($this->table)->where('id', '=', $id)->delete();

            $error   = 0;
            $message = "Data berhasil dihapus";
            $msg_raw = $message;
            
        }  catch (QueryException $e) {
            $error   = $e->getCode();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
            $message = "Terjadi kesalahan pada database";
        } catch (Exception $e) {
            $error   = $e->getCode();
            $message = $e->getMessage();
            $msg_raw = get_class($e) . ": " . $e->getMessage();
        }
        
        return response()->json([
            "error"       => $error, 
            "message"     => $message,
            "message_raw" => $msg_raw
        ]);
    }

    /**
     * Datatable Personil Controller
     * @return mixed
     */
    public function data()
    {
        $data = DB::table($this->table);

        return Datatables::of($data)->make(true);
    }
}
