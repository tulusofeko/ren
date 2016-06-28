<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use InvalidArgumentException;
use Exception;
use App\Http\Requests;

class NodeController extends Controller
{
    protected $code_length = '3';

    public function show($kode = null) { }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'code'   => 'required|max:' . $this->code_length,
            'parent' => 'required|max:4'
        ]);

        try {
            $parent  = $request->input("parent");
            $code    = $request->input("code");
            $name    = $request->input("name");
            $params  = [['code', $code], ['parent', $parent]];

            $collect = call_user_func([$this->model, 'where'], $params);

            if (!$collect->get()->isEmpty()) {
                throw new InvalidArgumentException("Kode sudah tersedia", 422);
            }

            $output         = new $this->model;
            $output->name   = $name;
            $output->parent = $parent;
            $output->code   = $code;
            $output->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (InvalidArgumentException $e) {

            return response()->json(["message" => $e->getMessage()], 422);
        
        } catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }  
    }

    public function update($id, Request $request)
    {
        $output = call_user_func([$this->model, 'find'], $id);

        $this->validate($request, [
            'name'   => 'required',
            'code'   => 'required|max:' . $this->code_length,
            'parent' => 'required|max:4'
        ]);

        try {
            $parent = $request->input("parent");
            $code   = $request->input("code");
            $name   = $request->input("name");
            
            $params = [['code', $code], ['parent', $parent]];

            $collect = call_user_func([$this->model, 'where'], $params);
            if (!$collect->get()->isEmpty()) {
                if ($output->code != $code || $output->parent != $parent) {
                    throw new InvalidArgumentException("Kode sudah tersedia", 422);
                }
            }

            $output->name      = $name;
            $output->parent    = $parent;
            $output->code      = $code;
            $output->save();

            return response()->json(["message" => "Data berhasil disimpan"]);

        } catch (InvalidArgumentException $e) {

            return response()->json(["message" => $e->getMessage()], 422);
        
        } catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }

    public function delete($id) 
    {
        $output = call_user_func([$this->model, 'find'], $id);

        try {
            $output->delete();

            return response()->json(["message" => "Data berhasil dihapus"]);
            
        }  catch (Exception $e) {
            $message = get_class($e) . ": " . $e->getMessage();

            $jsonres = ["error" => $e->getCode(), "message" => $message];
            
            return response()->json($jsonres, 500);
        }
    }
}
