<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;

class UnitKerjaController extends Controller
{
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
